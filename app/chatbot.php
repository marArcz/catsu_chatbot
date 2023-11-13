<?php
require_once '../includes/session.php';

class Chatbot
{
    public const RESPONSE_ACTION = 1;
    public const RESPONSE_MESSAGE = 2;
    public const ACTION_GET_SCHOOL_YEARS = 'getSchoolYears';
    public const ACTION_GET_GRADES = 'getGrades';
    public const ACTION_GET_ENROLLED_COURSES = 'getEnrolledCourses';
    public $chatBotActionSession = 'chatbot_action_session';

    public function __construct(public PDO $pdo, public $user)
    {
    }

    function getSchoolYears(string $action, string $message = "All right, in what school year should I look for?"): array
    {
        $schoolYears = [];
        $query = $this->pdo->prepare("SELECT * FROM enrollments WHERE student_id_no = ?");
        $query->execute([$this->user['student_id_no']]);

        if ($query->rowCount() == 0) {
            return [
                'message' => "I'm sorry, but I can't find any record of your enrollment. Please understand that your record may still not have been inputted into the system, otherwise please contact our staff about the issue. Thank You!",
                'suggestions' => [],
                'action' => '',
                'end' => false
            ];
        } else {
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $schoolYears[] = $row['year_start'] . '-' . $row['year_end'];
            }

            return [
                'message' => $message,
                'suggestions' => $schoolYears,
                'action' => $action,
                'end' => false
            ];
        }
    }

    function getGrades(string $user_query): array
    {
        $schoolYearSession = 'chatbot_grades_school_year';
        if (stristr($user_query, 'semester') && Session::hasSession($schoolYearSession)) {
            $schoolYear = Session::getSession($schoolYearSession);
            $semester = stristr($user_query, '1st') ? 1 : 2;
            $yearStart = explode('-', $schoolYear)[0];
            $yearEnd = explode('-', $schoolYear)[1];

            $response = file_get_contents('./chatbot_responses/grades.html');
            $response = str_replace('{school_year}', "$yearStart - $yearEnd", $response);
            $response = str_replace('{semester}', $semester == 1 ? '1st semester' : '2nd semester', $response);
            $grades = "";

            // get enrolled courses
            $get_enrolled_courses = $this->pdo->prepare("SELECT enrolled_courses.*,courses.name as course_name,courses.code as course_code FROM enrolled_courses INNER JOIN courses ON enrolled_courses.course_code = courses.code WHERE enrollment_id IN (SELECT id FROM enrollments WHERE year_start = ? AND year_end = ?) AND enrolled_courses.semester=?");
            $get_enrolled_courses->execute([$yearStart, $yearEnd, $semester]);

            $enrolled_courses = $get_enrolled_courses->fetchAll(PDO::FETCH_ASSOC);

            if ($enrolled_courses) {
                foreach ($enrolled_courses as $key => $enrolled_course) {
                    $course_name = $enrolled_course['course_name'];
                    $course_code = $enrolled_course['course_code'];

                    // get grade for this course
                    $get_grade = $this->pdo->prepare('SELECT * FROM grades WHERE course_code LIKE ? AND student_id_no = ? AND semester = ?');
                    $get_grade->execute(["%$course_code%", $this->user['student_id_no'],$semester]);
                    $grade = $get_grade->fetch(PDO::FETCH_ASSOC);
                    $grade = number_format($grade['grade'], 1) ?? 'N/A';

                    $grades .= "<li class='list-group-item d-flex align-items-center justify-content-between'>" .
                        "<small class='text-secondary'>$course_name</small>" .
                        "<small class='fw-bold'>$grade</small>" .
                        "</li>";
                }

                $response = str_replace('{grades}', $grades, $response);

                Session::removeSession($schoolYearSession);
                Session::removeSession($this->chatBotActionSession);
                return [
                    'message' => $response,
                    'suggestions' => ['Start over'],
                    'action' => '', //next action
                    'end' => true
                ];
            } else {
                $response = "Sorry I can't find any courses you enrolled for the school year {schoolYear}, {semester}";
                $response = str_replace('{schoolYear}',$yearStart . '-' . $yearEnd,$response);
                $response = str_replace('{semester}', $semester == 1 ? '1st semester' : '2nd semester', $response);
                return [
                    'message' => $response,
                    'suggestions' => ['Start over'],
                    'action' => '', //next action
                    'end' => true
                ];
            }
        } else if (count(explode('-', $user_query)) == 2) {
            $yearStart = explode('-', $user_query)[0];
            $yearEnd = explode('-', $user_query)[1];
            Session::insertSession($schoolYearSession, "$yearStart-$yearEnd");
            // semesters
            return [
                'message' => "In what semester?",
                'suggestions' => ['1st semester', '2nd semester'],
                'action' => $this::ACTION_GET_GRADES, //next action
                'end' => false
            ];
        } else {
            $get_queries = $this->pdo->prepare('SELECT * FROM queries WHERE response_id IN (SELECT id FROM response WHERE action_id IN(SELECT id FROM actions WHERE action=?))');
            $get_queries->execute([$this::ACTION_GET_GRADES]);
            $queries = $get_queries->fetchAll(PDO::FETCH_ASSOC);
            $matched = false;
            foreach ($queries as $key => $query) {
                if (stristr($user_query, $query['keyword']) || stristr($user_query, $query['keyword'])) {
                    $matched = true;
                    break;
                }
            }

            if ($matched) {
                return $this->getSchoolYears($this::ACTION_GET_GRADES);
            } else {
                if (Session::hasSession($schoolYearSession)) {
                    return [
                        'message' => 'Please select a semester',
                        'action' => $this::ACTION_GET_GRADES,
                        'end' => false
                    ];
                } else {
                    return [
                        'message' => 'Sorry I have no response to query, please try rephrasing it and try again!',
                        'action' => $this::ACTION_GET_GRADES,
                        'end' => false
                    ];
                }
            }
        }
    }

    function getEnrolledCourses(string $user_query): array
    {
        $schoolYearSession = 'chatbot_enrolled_courses_school_year';
        if (stristr($user_query, 'semester') && Session::hasSession($schoolYearSession)) {
            $schoolYear = Session::getSession($schoolYearSession);
            $semester = stristr($user_query, '1st') ? 1 : 2;
            $yearStart = explode('-', $schoolYear)[0];
            $yearEnd = explode('-', $schoolYear)[1];


            $response = file_get_contents('./chatbot_responses/enrolled_courses.html');
            $response = str_replace('{school_year}', "$yearStart - $yearEnd", $response);
            $response = str_replace('{semester}', $semester == 1 ? '1st semester' : '2nd semester', $response);
            $enrolled_course_response = "";

            // get enrolled courses
            $get_enrolled_courses = $this->pdo->prepare("SELECT enrolled_courses.*,courses.name as course_name,courses.code as course_code FROM enrolled_courses INNER JOIN courses ON enrolled_courses.course_code = courses.code WHERE student_id_no = ? AND enrollment_id IN (SELECT id FROM enrollments WHERE year_start=? AND year_end=?) AND enrolled_courses.semester=?");
            $get_enrolled_courses->execute([$this->user['student_id_no'], $yearStart, $yearEnd, $semester]);

            $enrolled_courses = $get_enrolled_courses->fetchAll(PDO::FETCH_ASSOC);

            foreach ($enrolled_courses as $key => $enrolled_course) {
                $course_name = $enrolled_course['course_name'];
                $course_code = $enrolled_course['course_code'];


                $enrolled_course_response .= "<li class='list-group-item d-flex align-items-center justify-content-between'>" .
                    "<small class='text-secondary'>$course_code</small>" .
                    "<small class='text-secondary'>-</small>" .
                    "<small class='text-secondary'>$course_name</small>" .
                    "</li>";
            }

            $response = str_replace('{courses}', $enrolled_course_response, $response);

            Session::removeSession($schoolYearSession);
            Session::removeSession($this->chatBotActionSession);
            return [
                'message' => $response,
                'suggestions' => ['Start over'],
                'action' => '', //next action
                'end' => true
            ];
        } else if (count(explode('-', $user_query)) == 2) {
            $yearStart = explode('-', $user_query)[0];
            $yearEnd = explode('-', $user_query)[1];
            Session::insertSession($schoolYearSession, "$yearStart-$yearEnd");
            // semesters
            return [
                'message' => "What semester?",
                'suggestions' => ['1st semester', '2nd semester'],
                'action' => $this::ACTION_GET_ENROLLED_COURSES, //next action
                'end' => false
            ];
        } else {
            if (stristr($user_query, 'see enrolled courses') || stristr($user_query, 'know my enrolled courses')) {
                return $this->getSchoolYears($this::ACTION_GET_ENROLLED_COURSES, "What school year please?");
            } else {
                if (Session::hasSession($schoolYearSession)) {
                    return [
                        'message' => 'Please select a semester',
                        'action' => $this::ACTION_GET_ENROLLED_COURSES,
                        'suggestions' => [],
                        'end' => false
                    ];
                } else {
                    return [
                        'message' => 'Sorry I have no response to query, please try rephrasing it and try again!',
                        'suggestions' => [],
                        'action' => $this::ACTION_GET_ENROLLED_COURSES,
                        'end' => false
                    ];
                }
            }
        }
    }
}
