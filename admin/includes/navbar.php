<nav id="navbar" class="navbar bg-dark-blue navbar-dark shadow-sm py-0">
    <div class="w-100 ">
        <div class="container-fluid d-flex align-items-center py-1">
            <div>
                <button class="btn btn-sm text-warning border-0" id="menu-toggler" type="button"><i class="bi bi-list fs-4 "></i></button>
            </div>
            <div class="ms-auto" id="navbarNav">
                <ul class="nav flex-row ms-auto align-items-center my-0">
                    <li class="nav-item">
                        <!-- <a class="nav-link link-dark text-uppercase fs-6 fw-bold <?= $current_page == 'profile' ? 'active' : '' ?> " href="profile.php">
                            <?php if ($admin['image'] == '') : ?>
                                <div class="text-profile-pic bg-light text-dark shadow-sm bg-opacity-75 ">
                                    <div class="text">
                                        <?= $admin['firstname'][0] .  $admin['lastname'][0] ?>
                                    </div>
                                </div>
                            <?php endif ?>
                        </a> -->

                        <div class="dropdown">
                            <button class="btn btn-sm " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="text-profile-pic bg-light text-dark shadow-sm bg-opacity-75 ">
                                    <div class="text">
                                        <?= $admin['firstname'][0] .  $admin['lastname'][0] ?>
                                    </div>
                                </div>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end py-0">
                                <li class="border-bottom py-1">
                                    <a class="dropdown-item" href="view_response.php?id=<?= $row['id'] ?>">
                                        <i class="bi bi-person-fill me-2"></i>
                                        <small>Profile</small>
                                    </a>
                                </li>
                                <li class="border-bottom py-2">
                                    <a class="dropdown-item delete" href="../app/logout.php">
                                        <i class="bi bi-sign-out me-2"></i>
                                        <small>Log out</small>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="bg-white border-top w-100 px-3 py-2">
            <nav aria-label="breadcrumb my-0">
                <ol class="breadcrumb my-0 justify-content-lg-start justify-content-center" id="breadcrumb">
                    <li class="breadcrumb-item active fw-semibold" aria-current="page" id="current-page"><?= $header_title ?? $_ENV['APP_NAME'] ?></li>
                </ol>
            </nav>
        </div>
    </div>
</nav>