<?php
require '../conn/conn.php';
require '../includes/session.php';
require './chatbot.php';



if (isset($_POST['action'])) {

} else {
    $keyword = $_POST['query'];
    $query = $pdo->prepare('SELECT * FROM queries WHERE keyword LIKE ?');
    $query->execute(["%$keyword%"]);

    $result = $query->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        // get response
        $query = $pdo->prepare("SELECT response.*,response_types.name,response_types.code FROM response INNER JOIN response_types ON response.response_type_id = response_types.id WHERE response.id = ?");
        $query->execute([$result['response_id']]);
        $response = $query->fetch(PDO::FETCH_ASSOC);

        if ($response) {
            if ($response['code'] == Chatbot::RESPONSE_ACTION) {
                // get action
                $query = $pdo->prepare('SELECT * FROM actions WHERE id = ?');
                $query->execute([$response['action_id']]);
                $action = $query->fetch(PDO::FETCH_ASSOC);
                
                $chatbot = new Chatbot($pdo,Session::getUser($pdo));
                if($action['action'] == $chatbot::ACTION_GET_GRADES){
                    // $res = $chatbot->getGrades($_POST['']); 
                }

                echo json_encode($res);
            }
        } else {
            echo json_encode([
                'message' => "Sorry, I don't have any response to your query. Try to rephrase or rewrite your query. Thanks!",
                'end' => false
            ]);
        }
    } else {
        echo json_encode([
            'message' => "Sorry, I don't have any response to your query. Try to rephrase or rewrite your query. Thanks!",
            'end' => false
        ]);
    }
}
