<?php 
    require_once '../conn/conn.php';
    require_once '../includes/session.php';
    if(isset($_POST['change_pass'])){
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];

        $user = Session::getUser($pdo);

        if(password_verify($current_password, $user['password'])){
            if(strlen($new_password) >= 6){
                $new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $query = $pdo->prepare('UPDATE students SET password = ? WHERE id = ?');
                $query->execute([$new_password,$user['id']]);
                
                Session::insertSuccess("Successfully changed password!");

                echo json_encode([
                    "success" => true
                ]);
            }else{
                echo json_encode([
                    "success" => false,
                    "new_password_error" => "Password must be at least 6 characters long"
                ]);
            }
        }else{
            echo json_encode([
                "success" => false,
                "current_password_error" => "Current password you entered is incorrect",
            ]);
        }
        exit;
    }
?>