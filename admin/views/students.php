<?php require_once '../includes/authenticated.php' ?>
<?php
if (isset($_POST['filter'])) {
    $filter_params = [];
    $where_clauses = [];
    
    if (isset($_POST['program_id']) && $_POST['program_id']) {
        $where_clause['sql_where'] = 'students.program_id = :program_id ';
        $where_clause['filter_param'] = [
            ':program_id',$_POST['program_id']
        ];
        array_push($where_clauses,$where_clause);
    } 
    if (isset($_POST['year_level']) && $_POST['year_level']) {
        $where_clause['sql_where'] = 'students.year_level = :year_level ';
        $where_clause['filter_param'] = [
            ':year_level',$_POST['year_level']
        ];
        array_push($where_clauses,$where_clause);
    } 
    if (isset($_POST['block']) && $_POST['block']) {
        $where_clause['sql_where'] = 'students.block = :block ';
        $where_clause['filter_param'] = [
            ':block',$_POST['block']
        ];
        array_push($where_clauses,$where_clause);
    }
    $sql_where = count($where_clauses) > 0?"WHERE ":'';
    foreach ($where_clauses as $key => $row) {
        $sql_where .= $row['sql_where'];
        $filter_params[$row['filter_param'][0]] = $row['filter_param'][1];
        if($key < count($where_clauses) - 1){
           $sql_where .= "AND " ;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Record | Admin</title>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="bg-light">
    <?php $current_page = 'students' ?>
    <?php require_once '../includes/sidebar.php' ?>
    <main id="main" class="<?= Session::hasSession("closed_sidebar") ? 'expanded':'' ?>">
        <?php $header_title = 'Manage Student Record'; ?>
        <?php require_once '../includes/navbar.php' ?>
        <div class="content">
            <div class="container-fluid">
                <div class="mb-2">
                    <button class="btn btn-light rounded-1 text-dark-blue dropdown-toggle <?= isset($_POST['filter'])? 'active':'' ?>" id="filter-btn" type="button" data-bs-toggle="collapse" data-bs-target="#filter-collapse" aria-expanded="false">
                        <span class="fw-bold">Filters</span>
                    </button>
                    <div class="collapse px-2 mt-3 <?= isset($_POST['filter'])? 'show':'' ?>" id="filter-collapse">
                        <form id="filter-form" method="post">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md">
                                            <label for="" class="form-label">Program: </label>
                                            <select name="program_id" class="form-select form-select-sm rounded-1" id="program">
                                                <option value="">Any</option>
                                                <?php
                                                $query = $pdo->prepare('SELECT * FROM programs');
                                                $query->execute();

                                                while ($row = $query->fetch()) {
                                                ?>
                                                    <option <?= isset($_POST['program_id'])?($row['id'] == $_POST['program_id']?"selected":""):"" ?> value="<?= $row['id'] ?>"><?= $row['program_name'] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md">
                                            <label for="" class="form-label">Year level:</label>
                                            <select name="year_level" class="form-select form-select-sm rounded-1" id="year-level">
                                                <option value="">Any</option>
                                                <?php for ($i = 1; $i <= 4; $i++) {
                                                ?>
                                                    <option <?= isset($_POST['year_level'])?($i == $_POST['year_level']?"selected":""):"" ?> value="<?= $i ?>"><?= $i ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md">
                                            <label for="" class="form-label">Block:</label>
                                            <select name="block" class="form-select form-select-sm rounded-1" id="block">
                                                <option value="">Any</option>
                                                <option <?= isset($_POST['block'])?("A" == $_POST['block']?"selected":""):"" ?> value="A">A</option>
                                                <option <?= isset($_POST['block'])?("B" == $_POST['block']?"selected":""):"" ?> value="B">B</option>
                                            </select>
                                        </div>
                                        <div class="col-md align-self-end">
                                            <button type="submit" name="filter" class="btn btn-dark-blue btn-sm">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <table id="data-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Lastname</th>
                                    <th>Firstname</th>
                                    <th>Middlename</th>
                                    <th>Student ID No.</th>
                                    <th>Program</th>
                                    <th>Year level</th>
                                    <th>Block</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_POST['filter'])) {
                                    $query = $pdo->prepare('SELECT students.*, programs.program_name FROM students INNER JOIN programs ON students.program_id = programs.id ' . $sql_where);
                                    $query->execute($filter_params);
                                } else {
                                    $query = $pdo->prepare('SELECT students.*, programs.program_name FROM students INNER JOIN programs ON students.program_id = programs.id');
                                    $query->execute();
                                }
                                $i = 1;
                                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $row['lastname'] ?></td>
                                        <td><?= $row['firstname'] ?></td>
                                        <td><?= $row['middlename'] ?></td>
                                        <td><?= $row['student_id_no'] ?></td>
                                        <td><?= $row['program_name'] ?></td>
                                        <td><?= $row['year_level'] ?></td>
                                        <td><?= $row['block'] ?></td>
                                        <td>
                                            <a href="" class="btn btn-sm btn-success text-decoration-none me-1">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="" class=" text-decoration-none btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require_once '../includes/scripts.php' ?>
    <script>
        $("#data-table").DataTable();

        $("#filter-collapse").on('show.bs.collapse', function(e) {
            $("#filter-btn").addClass('active')
        })
        $("#filter-collapse").on('hide.bs.collapse', function(e) {
            $("#filter-btn").removeClass('active')
        })
    </script>
</body>

</html>