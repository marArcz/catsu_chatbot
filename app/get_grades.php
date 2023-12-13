<?php 
    require_once '../conn/conn.php';
    require_once '../includes/session.php';
    require_once './chatbot.php';

    $school_year = $_POST['school_year'];
    $yearStart = explode('-', $school_year)[0];
    $yearEnd = explode('-', $school_year)[1];

    $chatbot = new Chatbot($pdo,Session::getUser($pdo));

    echo json_encode($chatbot->getGrades($yearStart, $yearEnd));
?>