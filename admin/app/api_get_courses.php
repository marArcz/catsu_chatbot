<?php 
    require_once '../../conn/conn.php';

    $program_id = $_GET['program_id'];
    $query = $pdo->prepare("SELECT * FROM courses WHERE program_id = ?");
    $query->execute([$program_id]);

    $courses = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "courses"=> $courses
    ]);
?>