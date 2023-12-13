<?php 
    require_once '../../conn/conn.php';
    if(isset($_POST['submit'])){
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $student_id_no = $_POST['student_id_no'];

        $query = $pdo->prepare("UPDATE students SET firstname=?,middlename=?,lastname=? WHERE student_id_no=?");
        $query->execute([$firstname,$middlename,$lastname,$student_id_no]);

        Session::insertSuccess("Successfully updated student!");
        Session::redirectTo("manage_students.php?st=" . $student_id_no);
        exit;
    }
?>
