<?php 
    require_once '../conn/conn.php';
    require_once '../includes/session.php';
    require_once './chatbot.php';

    $chatbot = new Chatbot($pdo,Session::getUser($pdo));

    // echo json_encode($chatbot->getSchoolYears());
?>