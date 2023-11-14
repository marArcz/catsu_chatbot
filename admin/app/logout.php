<?php
require_once '../../conn/conn.php';
require_once '../includes/session.php';
if (Session::getUser($pdo)) {
    Session::destroyUserSession();
}

Session::redirectTo('../views/login.php');
