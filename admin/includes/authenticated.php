<?php 
    require_once '../../conn/conn.php';
    require_once '../includes/session.php';
    require_once '../app/config.php';

    $admin = Session::getUser($pdo);

    if(!$admin){
        Session::redirectTo('login.php');
        exit;
    }else{
        if($admin['email_verified_at'] == null){
            Session::redirectTo('verify.php');
        }
    }
?>
