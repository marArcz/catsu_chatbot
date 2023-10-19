<?php

declare(strict_types=1);
const USER_SESSION_NAME = "catsu_chatbot_student";

session_start();
class Session
{
    public static function redirectTo(string $url)
    {
        return header("location: $url");
    }
    public static function insertSession(string $key, string $value)
    {
        $_SESSION[$key] = $value;
    }
    public static function hasSession(string $key)

    {
        return isset($_SESSION[$key]);
    }
    public static function insertSuccess(string $message)
    {
        self::insertSession("success",$message);
    }


    public static function saveUserSession(int $userId)
    {
        $_SESSION[USER_SESSION_NAME] = $userId;
    }

    public static function getUser(PDO $pdo)
    {
        if (!isset($_SESSION[USER_SESSION_NAME])) {
            return null;
        }
        //get user
        $user_id = $_SESSION[USER_SESSION_NAME];
        $query = $pdo->prepare("SELECT * FROM students WHERE id = ?");
        $query->execute([$user_id]);

        if ($query->rowCount() == 0) {
            //if no user found
            return null;
        } else {
            $user = $query->fetch(PDO::FETCH_ASSOC);
            return $user;
        }
    }

    public static function insertError(string $message = "Something went wrong, please try again later!")
    {
        self::insertSession("error",$message);
    }

    public static function getSession(string $key, bool $remove = true)
    {
        $val = $_SESSION[$key];
        if ($remove) {
            unset($_SESSION[$key]);
        }

        return $val;
    }

    public static function getSuccess(bool $remove = true)
    {
        return self::getSession("success", $remove);
    }

    public static function getError(bool $remove = true)
    {
        return self::getSession("error", $remove);
    }


    public static function removeSession(string $key){
        unset($_SESSION[$key]);
    }

    public static function destroyUserSession(){
        if(isset($_SESSION[USER_SESSION_NAME])){
            self::removeSession(USER_SESSION_NAME);
        }
    }
}
