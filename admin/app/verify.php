<?php 
    require_once '../../conn/conn.php';

    if(isset($_POST['verify'])){
        $verification_code = $_POST['verification_code'];
        $admin = Session::getUser($pdo);

        if($admin['verification_code'] == $verification_code){
            $query = $pdo->prepare('UPDATE admins SET email_verified_at = CURRENT_TIMESTAMP() WHERE id = ?');
            $query->execute([$admin['id']]);
            Session::insertSuccess('Welcome admin!');
            Session::redirectTo('dashboard.php');
            exit;
        }else{
            $error = 'Sorry the verification code you entered is incorrect!';
        }
    }
?>