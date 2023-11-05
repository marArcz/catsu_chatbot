<?php 
if(isset($_POST['submit'])){
    require_once '../../conn/conn.php';

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

   
    if($password != $confirm_password){
        $error['confirm_password'] = $error['password'] = 'Passwords does not match!';
    }else{
        $password = password_hash($confirm_password, PASSWORD_DEFAULT);
        $query = $pdo->prepare('INSERT INTO admins(firstname,lastname,username,email,password) VALUE(?,?,?,?,?)');
        $query->execute([$firstname,$lastname,$username,$email,$password]);
        
        Session::insertSuccess('Successfully created your account!');
        Session::redirectTo('login.php');
        exit;
    }
}
?>