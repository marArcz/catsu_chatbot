<?php
require_once '../../conn/conn.php';

if (isset($_POST['submit'])) {
    $enrollment_id = $_POST['id'];

    $get_enrollment = $pdo->prepare("SELECT * FROM enrollments WHERE id = ?");
    $get_enrollment->execute([$enrollment_id]);
    $enrollment = $get_enrollment->fetch(PDO::FETCH_ASSOC);

    $semester = $enrollment['semester'];
    $query = $pdo->prepare("SELECT courses.name,courses.code, enrolled_courses.* FROM enrolled_courses INNER JOIN courses ON enrolled_courses.course_code = courses.code WHERE enrolled_courses.enrollment_id = ?");
    $query->execute([$enrollment_id]);

    $edit_grade = $pdo->prepare('UPDATE grades SET grade = ? WHERE course_code = ? AND enrollment_id=?');
    $insert_grade = $pdo->prepare('INSERT INTO grades(grade, course_code,student_id_no,enrollment_id) VALUES(?,?,?,?)');

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $grade_val = $_POST[$row['code']];

        $find_grade = $pdo->prepare('SELECT * FROM grades WHERE course_code = ? AND enrollment_id = ?');
        $find_grade->execute([$row['course_code'], $row['enrollment_id']]);
        $grade = $find_grade->fetch();

        if ($grade) {
            $edit_grade->execute([$grade_val, $row['course_code'],$enrollment['id']]);
        }else{
            $insert_grade->execute([$grade_val, $row['course_code'],$enrollment['student_id_no'],$enrollment['id']]);
        }
    }
    Session::insertSuccess("Successfully updates grades!");
    Session::redirectTo("grades.php?st=" . $enrollment['student_id_no']);
    exit;
}
