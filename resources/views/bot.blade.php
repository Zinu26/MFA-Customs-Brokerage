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
            <h3 class="chatbot-title">MFA Customs Brokerage</h3>
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
            <div id="faq-box" class="container-fluid p-2" style="height: calc(100vh - 130px); overflow-y: scroll;">
            </div>
            <div id="content-box" class="container-fluid p-2" style="height: calc(100vh - 130px); overflow-y: scroll;">
            </div>
        </div>
        <div class="container-fluid w-100 px-3 py-2 d-flex" style="background: #29924c; height: 62px;">
            <div class="mr-2 pl-2" style="background: #ffffff1c; width: calc(100% - 45px); border-radius: 5px;">
                <select id="input" name="faq" class="text-black"
                    style="background: none; width:100%; height: 100%; border: 0; outline: none;">
                    <option value="" class="text-center" disabled selected>--------SELECT QUESTION--------
                    </option>
                    @foreach ($faqs as $faq)
                        <option value="{{ $faq->answer }}">{{ $faq->question }}</option>
                    @endforeach
                </select>
            </div>

            <div id="button-submit" class="text-center"
                style="background: #146b31; height: 100%; width: 50px; border-radius: 5px; cursor: pointer;">
                <i class="fa fa-paper-plane text-white" aria-hidden="true" style="line-height: 45px;"></i>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
    crossorigin="anonymous"></script>
<script>
    $('#button-submit').on('click', function() {
        $value = $('#input').val();
        $('#faq-box').append(`<div class="mb-2">
        <div class="float-right px-3 py-2" style="width: 270px; background: #5dd184; border-radius: 10px; float: right; font-size: 85%;"> ${$('#input option:selected').text()}</div>
        <div style="clear: both;"></div>
    </div>

                <div class="d-flex mb-2">
            <div class="mr-2" style="width: 65px; height: 55px;">
                <img src="images/bot-avatar.jpg" width="100%"
                    height="100%" style="border-radius: 50px;">
            </div>
            <div class="text-white px-3 py-2"
                style="width: 270px; background: #29924c; border-radius: 10px; font-size: 85%;">
            </div>
            </div>`);

        let index = 0;
        let messageBox = $('#faq-box .text-white:last');
        let message = $value;

        function appendLetter() {
            if (index < message.length) {
                messageBox.append(message.charAt(index));
                index++;
                setTimeout(appendLetter, 50); // delay between letters in milliseconds
            }
        }

        setTimeout(appendLetter, 1000); // delay before starting in milliseconds

        $.ajax({
            type: 'post',
            url: '{{ route('sendChat') }}',
            data: {
                'input': $value
            },
        })
    })
</script>

<!-- Add this script tag before the closing body tag -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/guzzle.js/5.3.0/guzzle.min.js"></script>


<script src="https://kit.fontawesome.com/8d1be3a7c9.js" crossorigin="anonymous"></script>

<!-- Script for chatbot functionality -->
<script>
    // Get elements from DOM
    const chatbotToggle = document.getElementById("chatbot-toggle");
    const chatbotWindow = document.getElementById("chatbot-window");
    const chatbotCloseBtn = document.getElementById("chatbot-close-btn");

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
</script>
