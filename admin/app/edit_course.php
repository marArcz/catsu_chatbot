<?php 
    require_once '../../conn/conn.php';

  if(isset($_POST['submit'])){
    $code = $_POST['code'];
    $name = $_POST['name'];
    $id = $_GET['id'];

    $find_course = $pdo->prepare("SELECT * FROM courses WHERE code = ? AND id != ?");
    $find_course->execute([$code,$id]);
    $exist = $find_course->fetch(PDO::FETCH_ASSOC);

    if($exist){
        $error = "A course with this course code already exists!";
    }else{
        $query = $pdo->prepare("UPDATE courses SET code=?,name=? WHERE id = ?");
        $query->execute([$code,$name,$id]);

        Session::insertSuccess("Successfully updated course!");
        Session::redirectTo("courses.php");
        exit;
    }
  }
?>