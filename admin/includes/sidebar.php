<div class="sidebar bg-dark-blue-accent shadow ">
    <div class="sidebar-header bg-dark-blue">
        <a class=" d-flex link-light align-items-center text-decoration-none" href="#">
            <img src="../../assets/images/catsu.png" width="40" alt="">
            <small class="ms-2 fw-bold"><?= $_ENV['APP_NAME'] ?></small>
        </a>
    </div>
    <ul class="nav mt-3">
        <?php
        $navItems = [
            'Dashboard' => [
                'link' => 'dashboard.php',
                'key' => 'dashboard',
                'icon'=>'bi bi-house-fill'
            ],
            'Student records' => [
                'link' => 'manage_students.php',
                'key' => 'students',
                'icon'=>'bi bi-person-fill'
            ],
            'Enrollment records' => [
                'link' => 'enrollment_record.php',
                'key' => 'enrollment_record',
                'icon'=>'bi bi-book'
            ],
            'Manage Responses' => [
                'link' => 'responses.php',
                'key' => 'responses',
                'icon'=>'bi bi-list-task    '
            ],
        ];
        ?>
        <?php foreach ($navItems as $name => $navItem) : ?>
            <li class="nav-item mb-2 <?= $current_page == $navItem['key'] ? 'active' : '' ?>">
                <a href="<?= $navItem['link'] ?>" class="nav-link link-light">
                    <i class="<?= $navItem['icon'] ?>"></i>
                    <span><?= $name ?></span>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
</div>