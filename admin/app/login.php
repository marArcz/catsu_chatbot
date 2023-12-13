<?php 
    require_once '../../conn/conn.php';
    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $query->execute([$username]);
        $admin = $query->fetch(PDO::FETCH_ASSOC);
        if($admin){
            if(password_verify($password, $admin["password"])){
                Session::saveUserSession($admin['id']);
                if($admin['email_verified_at'] == null){
                    Session::redirectTo('verify.php');
                }else{
                    Session::redirectTo('dashboard.php');
                }
                exit;
            }else{
                $error['password'] = 'You entered an incorrect password!';
            }
        }else{
            $error['username'] = 'Sorry no matching account found!';
        }
    }
?>