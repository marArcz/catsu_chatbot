<?php
require_once '../../conn/conn.php';
require_once '../includes/session.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = $pdo->prepare('DELETE FROM response WHERE id=?');
    $success = $query->execute([$id]);

    if($success){
        Session::insertSuccess('Successfully deleted response!');
    }else{
        Session::insertError();
    }

    Session::redirectTo('../views/responses.php');
}
