<?php 
    require_once '../../conn/conn.php';
    require_once '../includes/session.php';
    $id = $_GET['id'];
    $query = $pdo->prepare('DELETE FROM students WHERE id = ?');
    $query->execute([$id]);
    Session::insertSuccess('Successfully deleted student record!');
    Session::redirectTo("../views/manage_students.php");
?>