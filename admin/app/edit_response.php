<?php
if (isset($_POST['submit'])) {
    $response_id = $_POST['response_id'];
    $response_type = $_POST['response_type'];

    if ($response_type == 2) { //message
        $message = $_POST['response'];
        $keywords = $_POST['keywords'];
        // update response
        $query = $pdo->prepare('UPDATE response SET response_type_id = ?, message=? WHERE id = ?');
        $query->execute([$response_type, $message, $response_id]);

        // remove old keywords
        $query = $pdo->prepare('DELETE FROM queries WHERE response_id = ?');
        $query->execute([$response_id]);

        // save new keywords
        $save_keyword = $pdo->prepare('INSERT INTO queries(keyword,response_id) VALUES(?,?)');

        foreach ($keywords as $key => $keyword) {
            $save_keyword->execute([$keyword, $response_id]);
        }

        if (isset($_POST['suggestions'])) {
            $suggestions = $_POST['suggestions'];
            // remove old suggestions
            $query = $pdo->prepare('DELETE FROM suggestions WHERE response_id = ?');
            $query->execute([$response_id]);
            // save new suggestions
            $save_suggestion = $pdo->prepare('INSERT INTO suggestions(keyword,response_id) VALUES(?,?)');
            
            foreach ($suggestions as $key => $suggestion) {
                $save_suggestion->execute([$suggestion, $response_id]);
            }
        }else{
            // remove suggestions
            $query = $pdo->prepare('DELETE FROM suggestions WHERE response_id = ?');
            $query->execute([$response_id]);
        }
    } else {
        $action_id = $_POST['action'];
        // update response
        $query = $pdo->prepare('UPDATE response SET response_type_id = ?, message=?,action_id=? WHERE id = ?');
        $query->execute([$response_type, "",$action_id, $response_id]);
        $keywords = $_POST['keywords'];
         // remove old keywords
         $query = $pdo->prepare('DELETE FROM queries WHERE response_id = ?');
         $query->execute([$response_id]);
 
         // save new keywords
         $save_keyword = $pdo->prepare('INSERT INTO queries(keyword,response_id) VALUES(?,?)');
 
         foreach ($keywords as $key => $keyword) {
             $save_keyword->execute([$keyword, $response_id]);
         }
    }
    Session::insertSuccess('Successfully updated response!');
    Session::redirectTo('responses.php');

    exit;
}
