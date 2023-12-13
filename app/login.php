<?php 
    if(isset($_POST['submit'])){
        require_once '../conn/conn.php';
        require_once '../includes/session.php';

        $student_id_no = $_POST['student_id_no'];
        $password = $_POST['password'];

        $query = $pdo->prepare('SELECT * FROM students WHERE student_id_no=?');
        $query->execute([$student_id_no]);
        $student = $query->fetch(PDO::FETCH_ASSOC);

        if($student){
            if(password_verify($password, $student['password'])){
                Session::saveUserSession($student['id']);
                Session::insertSuccess('Welcome to catsu chatbot!');
                Session::redirectTo('home.php');
                exit;
            }else{
                $password_error = "You entered an incorrect!";
            }
        }else{
            $login_error = "Your credentials does not match any of our record.";
        }
    }
?>