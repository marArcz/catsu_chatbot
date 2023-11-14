<?php
require_once '../../conn/conn.php';
require_once '../includes/session.php';

$enrollment_id = $_GET['id'];

$query = $pdo->prepare("SELECT courses.name,courses.code, enrolled_courses.* FROM enrolled_courses INNER JOIN courses ON enrolled_courses.course_code = courses.code WHERE enrolled_courses.enrollment_id = ?");
$query->execute([$enrollment_id]);

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $find_grade = $pdo->prepare('SELECT * FROM grades WHERE course_code = ? AND enrollment_id = ?');
    $find_grade->execute([$row['course_code'], $row['enrollment_id']]);
    $grade = $find_grade->fetch();
?>
    <div class="mb-3">
        <label for="" class="form-label">
            <?= $row['name'] ?>
        </label>
        <input required type="text" class="form-control input-grades" name="<?= $row['course_code'] ?>" value="<?= $grade['grade'] ?? '' ?>">
    </div>
<?php
}

?>

<input type="hidden" name="id" value="<?= $enrollment_id ?>">
<input type="hidden" name="id" value="<?= $enrollment_id ?>">