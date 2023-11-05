<?php
require_once '../../conn/conn.php';

if (isset($_POST['submit'])) {
    $response_type = $_POST['response_type'];
    
    if($response_type == 2){ //message
        $response = $_POST['response'];
        $query = $pdo->prepare('INSERT INTO response(message,response_type_id) VALUES(?,?)');
        $query->execute([$response, $response_type]);
        $response_id = $pdo->lastInsertId();

        if(isset($_POST['keywords'])){
            $keywords = $_POST['keywords'];

            foreach ($keywords as $key => $keyword) {
                $query = $pdo->prepare('INSERT INTO queries(keyword,response_id) VALUES(?,?)');
                $query->execute([$keyword, $response_id]);
            }
        }
        
        if(isset($_POST['suggestions'])){
            $suggestions = $_POST['suggestions'];

            foreach ($suggestions as $key => $keyword) {
                $query = $pdo->prepare('INSERT INTO suggestions(keyword,response_id) VALUES(?,?)');
                $query->execute([$keyword, $response_id]);
            }
        }
    }else{ // action
        $action_id = $_POST['action'];

        $query = $pdo->prepare('INSERT INTO response(action_id,response_type_id) VALUES(?,?)');
        $query->execute([$action_id, $response_type]);
        $response_id = $pdo->lastInsertId();

        if(isset($_POST['keywords'])){
            $keywords = $_POST['keywords'];

            foreach ($keywords as $key => $keyword) {
                $query = $pdo->prepare('INSERT INTO queries(keyword,response_id) VALUES(?,?)');
                $query->execute([$keyword, $response_id]);
            }
        }
    }
    Session::insertSuccess("Successfully added new response!");
    Session::redirectTo('responses.php');
    exit;
}

?>
