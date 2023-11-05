<nav class="navbar navbar-expand-lg bg-dark-blue navbar-dark main-navbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="../assets/images/catsu.png" width="50" alt="">
            <span class="ms-2">Catsu Chatbot</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link text-uppercase fs-6 fw-bold <?= $current_page == 'home'?'active':'' ?> " href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase fs-6 fw-bold <?= $current_page == 'about'?'active':'' ?> " href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase fs-6 fw-bold <?= $current_page == 'profile'?'active':'' ?> " href="profile.php">
                        <!-- <i class="fi fi-rr-circle-user fs-5"></i> -->
                        Profile
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>