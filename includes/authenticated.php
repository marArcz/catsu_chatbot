<?php 
    require_once '../conn/conn.php';
    require_once '../includes/session.php';
    require_once '../app/config.php';

    $user = Session::getUser($pdo);
?>
