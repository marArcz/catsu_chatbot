<?php
require '../conn/conn.php';
require '../includes/session.php';
require './chatbot.php';

$chatBotActionSession = 'chatbot_action_session';

$keyword = $_POST['query'];
$query = $pdo->prepare("SELECT * FROM queries WHERE keyword LIKE :keyword OR :keyword LIKE CONCAT('%',keyword,'%') ORDER BY keyword DESC");
$query->execute(["keyword"=>$keyword]);

$result = $query->fetch(PDO::FETCH_ASSOC);


if (Session::hasSession($chatBotActionSession)) {
    $chatbot = new Chatbot($pdo, Session::getUser($pdo));
    $res = $chatbot->{Session::getSession($chatBotActionSession)}($keyword);

    echo json_encode($res);
} else if ($result) {
    // get response
    $query = $pdo->prepare("SELECT response.*,response_types.name as response_type,response_types.code FROM response INNER JOIN response_types ON response.response_type_id = response_types.id WHERE response.id = ?");
    $query->execute([$result['response_id']]);
    $response = $query->fetch(PDO::FETCH_ASSOC);

    if ($response) {
        if ($response['response_type'] == 'Action') {
            
            $query = $pdo->prepare("SELECT actions.action as action,response.*,response_types.name as response_type,response_types.code FROM response INNER JOIN response_types ON response.response_type_id = response_types.id INNER JOIN actions ON response.action_id = actions.id WHERE response.id = ?");
            $query->execute([$result['response_id']]);
            $response = $query->fetch(PDO::FETCH_ASSOC);

            Session::insertSession($chatBotActionSession, $response['action']);
        }
        echo json_encode($response);
    } else {
        echo json_encode([
            'message' => "Sorry, I don't have any response to your query. Try to rephrase or rewrite your query and try again!",
            'end' => true,
            'response' => $result
        ]);
    }
} else {

    echo json_encode([
        'message' => "Sorry, I don't have any response to your query. Try to rephrase or rewrite your query. Thanks!",
        'end' => true
    ]);
}
