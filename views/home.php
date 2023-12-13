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
    <?php $current_page = "home" ?>
    <?php require_once '../includes/navbar.php' ?>
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
                            <div class="card-body chatbox-container bg-light" id="chatbox-container">
                                <div id="chatbox" class="chatbox">
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
                                <div class="suggestion-list ps-3" id='suggestion-list'>
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
        const scrollDownChats = () => {
            var chatBoxContainer = $("#chatbox");

            chatBoxContainer.animate({
                scrollTop: chatBoxContainer.prop("scrollHeight")
            }, 1000);
        }
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

            scrollDownChats();
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
                                <div class="chat">
                                    ${response}
                                </div>
                            </div>
                        </div>
                        `
                );
            scrollDownChats();
        }

        const initBtnQueryActionListener = () => {
            $(".btn-query").on('click', function(e) {
                onBtnQueryClicked($(this));
            })
        }

        const onBtnQueryClicked = (btnQuery) => {
            var suggestionList = $("#suggestion-list")
            if ($(btnQuery).find(".query").text().toLowerCase() == 'start over') {
                setTimeout(() => {
                    suggestionList.html(`
                    
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
                                    </button>`)
                    initBtnQueryActionListener()
                    $("#chatbox").html("")
                    addResponse("How can I help you?");
                }, 700)

                return;
            }


            if ($(btnQuery).data("action") == null || $(btnQuery).data("action") == "") {
                sendQuery($(btnQuery).find('.query').text());
            } else {
                addQuery($(btnQuery).find('.query').text());
                $.ajax({
                    method: 'post',
                    url: '../app/chatbot_action_response.php',
                    data: {
                        query: $(btnQuery).find('.query').text(),
                        action: $(btnQuery).data("action")
                    },
                    dataType: 'json',
                    success: function(action_res) {
                        console.log(action_res)
                        if (action_res.suggestions.length > 0) {
                            suggestionList.html("");
                            let suggestionItem = `
                                        <button disabled type="button" class="btn btn-outline-dark-blue rounded-pill">
                                            <p class="my-0">
                                                <small class="query">...</small>
                                            </p>
                                        </button>
                                    `;

                            suggestionList.append(suggestionItem);
                        }
                        setTimeout(() => {
                            if (action_res.suggestions.length > 0) {
                                suggestionList.html("");

                            }
                            for (let suggestion of action_res.suggestions) {
                                let suggestionItem = `
                                        <button type="button" data-action="${action_res.action}" class="btn btn-outline-dark-blue btn-query rounded-pill">
                                            <p class="my-0">
                                                <small class="query">${suggestion}</small>
                                            </p>
                                        </button>
                                    `;

                                suggestionList.append(suggestionItem);
                            }

                            $(".btn-query").on('click', function(e) {
                                onBtnQueryClicked($(this));
                            })
                            addResponse(action_res.message)
                        }, 700)
                    },
                    error: function(err) {
                        console.error('error: ', err)
                    }
                })
            }
        }
        const sendQuery = (query) => {
            addQuery(query);
            $("#chatbox").append(`
            
            `)
            $.ajax({
                method: 'post',
                url: '../app/chatbot_response.php',
                data: {
                    query
                },
                dataType: 'json',
                success: function(res) {
                    console.log(res)
                    if (res.response_type == 'Action') {
                        let suggestionList = $("#suggestion-list");

                        $.ajax({
                            method: 'post',
                            url: '../app/chatbot_action_response.php',
                            data: {
                                query,
                                action: res.action
                            },
                            dataType: 'json',
                            success: function(action_res) {
                                console.log(action_res)
                                setTimeout(() => {
                                    if (action_res.suggestions?.length > 0) {
                                        suggestionList.html("");
                                        for (let suggestion of action_res.suggestions) {
                                            let suggestionItem = `
                                        <button type="button" data-action="${action_res.action}" class="btn btn-outline-dark-blue btn-query rounded-pill">
                                            <p class="my-0">
                                                <small class="query">${suggestion}</small>
                                            </p>
                                        </button>
                                    `;
                                            suggestionList.append(suggestionItem);
                                        }
                                    }


                                    if (action_res.suggestions?.length > 0) {
                                        initBtnQueryActionListener();
                                    }

                                    addResponse(action_res.message)
                                }, 700)
                            },
                            error: function(err) {
                                console.error(err)
                            }
                        })
                    } else {
                        setTimeout(() => addResponse(res.message), 700);
                    }
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

            $(".btn-query").on('click', function(e) {
                onBtnQueryClicked($(this));
            })

        })
    </script>
</body>

</html>