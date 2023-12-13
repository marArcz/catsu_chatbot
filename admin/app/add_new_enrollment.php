<?php
require_once '../../conn/conn.php';

if(isset($_POST['add_enrollment'])){
    $year_level = $_POST['year_level'];
    $semester = $_POST['semester'];
    $block = $_POST['block'];
    $program_id = $_POST['program_id'];
    $year_start = $_POST['year_start'];
    $year_end = $_POST['year_end'];
    $student_id_no = $_POST['student_id_no'];
    $query = $pdo->prepare("INSERT INTO enrollments(program_id,semester,year_level,block,year_start,year_end,student_id_no) VALUES(?,?,?,?,?,?,?)");
    $query->execute([$program_id,$semester,$year_level,$block,$year_start, $year_end,$student_id_no]);

    $enrollment_id = $pdo->lastInsertId();
    $courses = $_POST['courses'];
    $add_course = $pdo->prepare("INSERT INTO enrolled_courses(student_id_no,course_code,semester,year_level,enrollment_id) VALUES(?,?,?,?,?)");
    
    foreach ($courses as $key => $course_code) {
        $add_course->execute([$student_id_no, $course_code,$semester,$year_level,$enrollment_id]);
    }

    Session::insertSuccess("Successfully added!");
    Session::redirectTo("manage_students.php?st=" . $student_id_no);

    exit;
}

?>
