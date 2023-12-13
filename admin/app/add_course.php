<?php 
    require_once '../../conn/conn.php';

  if(isset($_POST['submit'])){
    $code = $_POST['code'];
    $name = $_POST['name'];
    $unit = $_POST['unit'];

    $find_course = $pdo->prepare("SELECT * FROM courses WHERE code = ?");
    $find_course->execute([$code]);
    $exist = $find_course->fetch(PDO::FETCH_ASSOC);

    if($exist){
        $error = "A course with this course code already exists!";
    }else{
        $query = $pdo->prepare("INSERT INTO courses(code,name,unit) VALUES(?,?,?)");
        $query->execute([$code,$name,$unit]);

        Session::insertSuccess("Successfully added new course!");
        Session::redirectTo("courses.php");
        exit;
    }
  }
?>