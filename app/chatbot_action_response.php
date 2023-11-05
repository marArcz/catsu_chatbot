<?php
require '../conn/conn.php';
require '../includes/session.php';
require './chatbot.php';



$keyword = $_POST['query'];
$action = $_POST['action'];

$chatbot = new Chatbot($pdo, Session::getUser($pdo));

$res = $chatbot->{$action}($keyword);

echo json_encode($res);