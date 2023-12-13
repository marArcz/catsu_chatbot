<?php
require_once '../../conn/conn.php';

if(isset($_POST['submit'])){
    $enrollment_id = $_GET['id'];

    $year_level = $_POST['year_level'];
    $semester = $_POST['semester'];
    $block = $_POST['block'];
    $program_id = $_POST['program_id'];
    $year_start = $_POST['year_start'];
    $year_end = $_POST['year_end'];
    $student_id_no = $_POST['student_id_no'];
    $update = $pdo->prepare("UPDATE enrollments SET semester = ?, year_level=?,block=?,year_start=?,year_end=? WHERE id=?");
    $update->execute([$semester,$year_level,$block,$year_start,$year_end,$enrollment_id]);
    
    Session::insertSuccess("Successfully updated!");
    header("location: manage_students.php?st=" . trim($student_id_no));

    exit;
}

?>
