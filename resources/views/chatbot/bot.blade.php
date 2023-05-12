<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/bot.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
        integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<div class="chatbot-wrapper">
    <button class="chatbot-toggle" id="chatbot-toggle">
        <img src="/images/chatbot.jpg" class="chatbot-img">
    </button>
    <div class="chatbot-window" id="chatbot-window">
        <div class="chatbot-header">
            <h3 class="chatbot-title">MFA Chatbot</h3>
            <button class="chatbot-close" id="chatbot-close-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18px"
                    height="18px">
                    <path
                        d="M18 6.41L17.59 6 12 11.59 6.41 6 6 6.41 11.59 12 6 17.59 6.41 18 12 12.41 17.59 18 18 17.59 12.41 12z" />
                </svg>
            </button>
        </div>
        <div class="chatbot-body" id="chatbot-body">
            <div></div>
            <div id="content-box" class="container-fluid p-2" style="overflow-y: hidden; margin-bottom: 100px;">
            </div>
        </div>
        <div class="container-fluid w-100 px-3 py-2 d-flex" style="background: #29924c; position: absolute; bottom: 0;">
            <div class="mr-2 pl-2" style="background: #ffffff1c; width: calc(100% - 45px); border-radius: 5px;">
                <input id="input" class="text-black" type="text" name="input"
                    style="background: none; width:100%; height: 100%; border: 0; outline: none;">
            </div>
            <div id="button-submit" class="text-center"
                style="background: #146b31; height: 100%; width: 50px; border-radius: 5px; cursor: pointer;">
                <i class="fa fa-paper-plane text-white" aria-hidden="true" style="line-height: 45px;"></i>
            </div>
        </div>
    </div>
</div>


<!-- Add this script tag before the closing body tag -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/guzzle.js/5.3.0/guzzle.min.js"></script>


<script src="https://kit.fontawesome.com/8d1be3a7c9.js" crossorigin="anonymous"></script>
<!-- Script for chatbot functionality -->
<script>
    // Get elements from DOM
    const chatbotToggle = document.getElementById("chatbot-toggle");
    const chatbotWindow = document.getElementById("chatbot-window");
    const chatbotCloseBtn = document.getElementById("chatbot-close-btn");
    const chatbotInput = document.getElementById("chatbot-input");
    const chatbotBody = document.getElementById("chatbot-body");

    // Function to create user message element
    function createUserMessageElement(message) {
        const userMessageContainer = document.createElement("div");
        userMessageContainer.classList.add("user-message-container");
        const userMessage = document.createElement("div");
        userMessage.classList.add("user-message");
        userMessage.textContent = message;
        userMessageContainer.appendChild(userMessage);
        return userMessageContainer;
    }

    // Function to create chatbot message element
    function createChatbotMessageElement(message) {
        const chatbotMessageContainer = document.createElement("div");
        chatbotMessageContainer.classList.add("chatbot-message-container");
        const chatbotMessage = document.createElement("div");
        chatbotMessage.classList.add("chatbot-message");
        chatbotMessage.textContent = message;
        chatbotMessageContainer.appendChild(chatbotMessage);
        return chatbotMessageContainer;
    }

    // Function to add message to chatbot body
    function addMessageToChatbotBody(messageElement) {
        chatbotBody.appendChild(messageElement);
        chatbotBody.scrollTop = chatbotBody.scrollHeight;
    }

    // Function to send user input to backend and get chatbot response
    function sendUserInputToBackend(userInput) {
        const formData = new FormData();
        formData.append("message", userInput);
        guzzle.post("/chatbot", {
            body: formData
        }).then((response) => {
            const chatbotResponse = response.body.response;
            const chatbotMessageElement = createChatbotMessageElement(chatbotResponse);
            addMessageToChatbotBody(chatbotMessageElement);
        });
    }

    // Event listener for chatbot toggle button
    chatbotToggle.addEventListener("click", () => {
        if (chatbotWindow.style.display === "none") {
            chatbotWindow.style.display = "flex";
            chatbotInput.focus();
        } else {
            chatbotWindow.style.display = "none";
        }
    });

    // Event listener for chatbot close button
    chatbotCloseBtn.addEventListener("click", () => {
        chatbotWindow.style.display = "none";
    });

    // Event listener for chatbot input
    chatbotInput.addEventListener("keydown", (event) => {
        if (event.key === "Enter") {
            const userInput = chatbotInput.value.trim();
            if (userInput) {
                const userMessageElement = createUserMessageElement(userInput);
                addMessageToChatbotBody(userMessageElement);
                chatbotInput.value = "";

                // Send user input to backend and get chatbot response
                sendUserInputToBackend(userInput);
            }
        }
    });
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    function promptForInput() {
        $('#content-box').append(`<div class="d-flex mb-2">
            <div class="mr-2" style="width: 65px; height: 55px;">
                <img src="/images/bot-avatar.jpg" width="100%" height="100%" style="border-radius: 50px;">
            </div>
            <div class="text-white px-3 py-2" style="width: 270px; background: #29924c; border-radius: 10px; font-size: 85%;">
                Hi, what can I do for you? Just provide a BL Number if you need fast track of your shipment
            </div>
        </div>`);
    }

    // call the function to prompt the user for input when the page loads
    promptForInput();

    function sendMessage() {
        // Check if input field is empty
        if ($('#input').val() === '') {
            $('#button-submit').prop('disabled', true);
            $('#button-submit').css('cursor', 'not-allowed');
            return;
        }

        // Disable input field and submit button
        $('#input').prop('disabled', true);
        $('#button-submit').prop('disabled', true);
        $('#input').css('cursor', 'not-allowed');

        $value = $('#input').val();
        $('#content-box').append(`<div class="mb-2">
                            <div class="float-right px-3 py-2" style="width: 270px; background: #5dd184; border-radius: 10px; float: right; font-size: 85%;">
                                ` + $value + `
                            </div>
                            <div style="clear: both;"></div>
                        </div>`);

        $.ajax({
            type: 'post',
            url: '{{ route('sendChat') }}',
            data: {
                'input': $value
            },
            success: function(data) {
                $('#content-box').append(`<div class="d-flex mb-2">
                                    <div class="mr-2" style="width: 65px; height: 55px;">
                                        <img src="/images/bot-avatar.jpg" width="100%" height="100%" style="border-radius: 50px;">
                                    </div>
                                    <div class="text-white px-3 py-2" style="width: 270px; background: #29924c; border-radius: 10px; font-size: 85%;">
                                    </div>
                                </div>`);

                let index = 0;
                let messageBox = $('#content-box .text-white:last');
                let message = data;

                function appendLetter() {
                    if (index < message.length) {
                        messageBox.append(message.charAt(index));
                        index++;
                        setTimeout(appendLetter, 50); // delay between letters in milliseconds
                    } else {
                        // Enable input field and submit button
                        $('#input').prop('disabled', false);
                        $('#button-submit').prop('disabled', false);
                        $('#input').css('cursor', 'text');

                        // Scroll down content box if it's scrollable
                        let contentBox = $('#content-box')[0];
                        if (contentBox.scrollHeight > contentBox.clientHeight) {
                            contentBox.scrollTop = contentBox.scrollHeight - contentBox
                                .clientHeight;
                        }
                    }
                }

                setTimeout(appendLetter, 1000); // delay before starting in milliseconds

                $value = $('#input').val('');
            }
        })
    }

    $('#button-submit').on('click', function() {
        sendMessage();
    })

    $('#input').on('keypress', function(e) {
        if (e.which === 13) { // enter key pressed
            sendMessage();
        }
    })
</script>


<script>
    var contentBox = document.getElementById("content-box");
    var maxContentHeight = parseInt(contentBox.style.height);

    function toggleContentScroll() {
        if (contentBox.scrollHeight > maxContentHeight) {
            contentBox.style.overflowY = "scroll";
        } else {
            contentBox.style.overflowY = "hidden";
        }
    }

    // Call toggleContentScroll when the window is resized or when the content is changed dynamically
    window.addEventListener("resize", toggleContentScroll);
    contentBox.addEventListener("DOMNodeInserted", toggleContentScroll);
</script>



{{-- For Testing purposes
    // Mock backend response
    function mockBackendResponse(userInput) {
    const response = "You said: " + userInput;
    return Promise.resolve({ body: { response } });
    }

    // Function to send user input to mock backend and get chatbot response
    function sendUserInputToBackend(userInput) {
    mockBackendResponse(userInput).then((response) => {
        const chatbotResponse = response.body.response;
        const chatbotMessageElement = createChatbotMessageElement(chatbotResponse);
        addMessageToChatbotBody(chatbotMessageElement);
    });
    } --}}
