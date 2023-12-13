<?php 
    require_once '../../conn/conn.php';
    if(isset($_POST['submit'])){
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $student_id_no = $_POST['student_id_no'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $check_student_id = $pdo->prepare('SELECT * FROM students WHERE student_id_no = ?');
        $check_student_id->execute([$student_id_no]);
        $exist = $check_student_id->fetch();

        if($exist){
            $error['student_id_no'] = "A student with this ID already exists.";
        }else{
            $query = $pdo->prepare("INSERT INTO students(firstname,middlename,lastname,student_id_no,password) VALUES(?,?,?,?,?)");
            $query->execute([$firstname,$middlename,$lastname,$student_id_no,$hashed_password]);

            Session::insertSuccess("Successfully added student!");
            Session::redirectTo("manage_students.php?st=" . $student_id_no);
            exit;
        }
    }
?>
