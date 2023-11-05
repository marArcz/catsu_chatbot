<?php require_once '../includes/authenticated.php' ?>
<?php 
    if(!isset($_GET['st'])){
        Session::redirectTo('students.php');
    }
    $student_id_no = $_GET['st'];

    // get student record
    $query = $pdo->prepare("SELECT * FROM students WHERE student_id_no = ?");
    $query->execute([$student_id_no]);

    $student = $query->fetch(PDO::FETCH_ASSOC);

    // redirect if no student is found
    if(!$student){
        Session::redirectTo("students.php");
    }
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Student | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php $current_page = 'students' ?>
    <?php require_once '../includes/sidebar.php' ?>
    <main>
        <?php $header_title = 'Manage Student Record'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-lg">
              
            </div>
        </div>
    </main>

    <?php require_once '../includes/scripts.php' ?>
    <script>
        $("#data-table").DataTable();
    </script>
</body>

</html>