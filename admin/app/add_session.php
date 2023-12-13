<?php 
require_once '../includes/session.php';

Session::insertSession($_POST['key'],$_POST['value']);
echo "successfully added";
