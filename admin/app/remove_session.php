<?php 
require_once '../includes/session.php';

Session::removeSession($_POST['key']);
echo "successfully removed";
