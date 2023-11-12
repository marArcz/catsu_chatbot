<?php 
    require_once '../../conn/conn.php';
    require_once '../includes/session.php';

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $query = $pdo->prepare('DELETE FROM courses WHERE id =?');
        if($query->execute([$id])){
            Session::insertSuccess("Successfully deleted course!");
        }else{
            Session::insertError();
        }
    }

    Session::redirectTo("../views/courses.php");
?>