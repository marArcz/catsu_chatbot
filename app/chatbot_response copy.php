<?php
require '../conn/conn.php';
require '../includes/session.php';
require './chatbot.php';

function getMatchingQuery($queries, $keyword)
{
    $result = null;
    $matchedQueries = [];

    foreach ($queries as $key => $user_query) {
        if (stristr($keyword, $user_query['keyword'])) {
            $matchedQueries[] = [
                "matched" => stristr($keyword, $user_query['keyword'],false),
                "query" => $user_query
            ];
        } else if (stristr($user_query['keyword'], $keyword)) {
            $matchedQueries[] = [
                "matched" => stristr($user_query['keyword'], $keyword,false),
                "query" => $user_query
            ];
        }
    }

    $mostMatchedIndex = 0;

    for ($x = 0; $x < count($matchedQueries); $x++) {
        $mostMatchedIndex = strlen($matchedQueries[$x]["matched"]) > $matchedQueries[$mostMatchedIndex]["matched"] ? $x : $mostMatchedIndex;
    }

    return $matchedQueries[$mostMatchedIndex]["query"];
}

$chatBotActionSession = 'chatbot_action_session';

$keyword = $_POST['query'];
$query = $pdo->prepare("SELECT * FROM queries");
$query->execute();

$queries = $query->fetchAll(PDO::FETCH_ASSOC);
$result = getMatchingQuery($queries,$keyword);

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
