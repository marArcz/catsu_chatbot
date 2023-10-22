<?php require_once '../includes/authenticated.php' ?>
<?php
$student = Session::getUser($pdo);
if ($student == null) {
    Session::redirectTo('login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $title = "Home" ?>
    <?php require_once '../includes/header.php' ?>
</head>

<body class="">
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
                        <a class="nav-link text-uppercase fs-6 fw-bold active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase fs-6 fw-bold" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase fs-6 fw-bold" href="#">
                            <!-- <i class="fi fi-rr-circle-user fs-5"></i> -->
                            Profile
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main>
        <div class="home-container">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md py-4 d-lg-block d-none">
                        <p class="fs-2 fw-bold text-light">Chatbot Student Support</p>
                        <p class="fs-5 text-light">For academic inquiries.</p>
                    </div>
                    <div class="col-md d-lg-none d-block">
                        <p class="fs-5 fw-bold my-1 text-light">Chatbot Student Support</p>
                        <p class="text-light">
                            <small>For academic inquiries.</small>
                        </p>
                    </div>
                    <div class="col-md-7">
                        <div class="card card-chatbox border-0 shadow">
                            <div class="card-header bg-white py-1">
                                <div class="d-flex align-items-center">
                                    <img src="../assets/images/Blink-bot.gif" width="130" alt="" class="img-fluid">
                                    <div class="ms-1">
                                        <p class="fw-bold my-1 text-secondary">Hi <?= $student['firstname'] ?>!</p>
                                        <p class="my-1 fw-bold">How can I help you today?</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body chatbox-container bg-light">
                                <div id="chatbox" class="chatbox">
                                    <div class="chat-item user">
                                        <div class="text-dark-blue">
                                            <p class="chat">Hello</p>
                                        </div>
                                        <div class="avatar">
                                            <i class="bi bi-person-fill fs-5"></i>
                                        </div>
                                    </div>
                                    <div class="chat-item">
                                        <div class="avatar">
                                            <img src="../assets/images/Blink-bot-sm.gif" />
                                        </div>
                                        <div class="text-dark-blue">
                                            <p class="chat">
                                                How can I help you?
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="suggestion-list">
                                    <button type="button" class="btn btn-outline-dark-blue btn-query rounded-pill">
                                        <p class="my-0">
                                            <small class="query">How does this work?</small>
                                        </p>
                                    </button>
                                    <button type="button" class="btn btn-outline-dark-blue btn-query rounded-pill">
                                        <p class="my-0">
                                            <small class="query">I want to see my grades</small>
                                        </p>
                                    </button>
                                    <button type="button" class="btn btn-outline-dark-blue btn-query rounded-pill">
                                        <p class="my-0">
                                            <small class="query">I want to know my enrolled courses</small>
                                        </p>
                                    </button>
                                </div>
                            </div>
                            <div class="card-footer py-3 bg-light">
                                <div class="chat-input-container">
                                    <form action="" id="chat-form">
                                        <input id="chat-input" type="text" placeholder="Write message" class="form-control chat-input border-0 me-2 shadow-sm rounded-4" name="chat" required>
                                        <button type="submit" class="btn btn-white border-0 d-flex align-items-center">
                                            <i class="fi fi-rr-paper-plane fs-5 leading-none"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- js scripts -->
    <?php require_once '../includes/scripts.php' ?>
    <script type="text/javascript" async src="https://tenor.com/embed.js"></script>
    <script>
        const sendQuery = (query) => {
            const addQuery = (q) => {
                $("#chatbox").append(
                    `<div class="chat-item user">
                        <div class="text-dark-blue">
                            <p class="chat">${q}</p>
                        </div>
                        <div class="avatar">
                            <i class="bi bi-person-fill fs-5"></i>
                        </div>
                    </div>`
                )
                .append(`
                <div class="chat-item chatbot-typing">
                    <div class="avatar">
                        <img src="../assets/images/Blink-bot-sm.gif" />
                    </div>
                    <div class="text-dark-blue">
                        <p class="chat">
                            ...
                        </p>
                    </div>
                </div>
                `)

                setTimeout(()=> addResponse("Sorry I can't understand you!"),2000);
                    
            }
            const addResponse = (response) => {
                
                $('.chatbot-typing').remove();
                
                $("#chatbox")
                .append(
                    `<div class="chat-item">
                        <div class="avatar">
                            <img src="../assets/images/Blink-bot-sm.gif" />
                        </div>
                        <div class="text-dark-blue">
                            <p class="chat">
                                ${response}
                            </p>
                        </div>
                    </div>
                    `
                );
            }

            addQuery(query);
            $("#chatbox").append(`
            
            `)
            $.ajax({
                method: 'post',
                url: '../app/generate_response.php',
                data: {
                    query
                },
                dataType: 'json',
                success: function(res) {
                    addResponse(res);
                }
            })
        }

        $(function() {
            $("#chat-form").on('submit', function(e) {
                e.preventDefault();
                let query = $("#chat-input").val();
                sendQuery(query);

                $("#chat-input").val('');
            })
        })
    </script>
</body>

</html>