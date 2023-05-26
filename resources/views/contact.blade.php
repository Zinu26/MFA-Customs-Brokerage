@include('layouts.inc.header')
@include('layouts.inc.topbarNav')
<link rel="stylesheet" href="/css/style.css" />
<style>
    *,
    *:before,
    *:after {
        box-sizing: border-box;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    body {
        margin: 0;
        padding: 0;
        background-color: #c8e7d8;
        color: #4e5e72;
        text-align: center;
        font-family: monospace;
        overflow: hidden;
    }

    body,
    button,
    input {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        letter-spacing: 1.4px;
    }

    small {
        display: block;
        padding: 1rem 0;
        font-size: 0.8rem;
        transition: opacity 0.33s;
    }

    .background {
        display: flex;
        min-height: 80vh;
    }

    .container {
        flex: 0 1 800px;
        margin: auto;
        padding: 10px;
    }

    .screen {
        position: relative;
        background: #3e3e3e;
        border-radius: 15px;
    }

    .screen:after {
        content: '';
        display: block;
        position: absolute;
        top: 0;
        left: 20px;
        right: 20px;
        bottom: 0;
        border-radius: 15px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, .4);
        z-index: -1;
    }

    .screen-header {
        display: flex;
        align-items: center;
        padding: 10px 20px;
        background: #4d4d4f;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .screen-header-left {
        margin-right: auto;
    }

    .screen-header-button {
        display: inline-block;
        width: 8px;
        height: 8px;
        margin-right: 3px;
        border-radius: 8px;
        background: white;
    }

    .screen-header-button.close {
        background: #ed1c6f;
    }

    .screen-header-button.maximize {
        background: #e8e925;
    }

    .screen-header-button.minimize {
        background: #74c54f;
    }

    .screen-header-right {
        display: flex;
    }

    .screen-header-ellipsis {
        width: 3px;
        height: 3px;
        margin-left: 2px;
        border-radius: 8px;
        background: #999;
    }

    .screen-body {
        display: flex;
    }

    .screen-body-item {
        flex: 1;
        padding: 50px;
    }

    .screen-body-item.left {
        display: flex;
        flex-direction: column;
    }

    .app-title {
        display: flex;
        flex-direction: column;
        position: relative;
        color: #ea1d6f;
        font-size: 26px;
    }

    .app-title:after {
        content: '';
        display: block;
        position: absolute;
        left: 0;
        bottom: -10px;
        width: 25px;
        height: 4px;
        background: #ea1d6f;
    }

    .app-contact {
        margin-top: auto;
        font-size: 8px;
        color: #888;
    }

    .app-form-group {
        margin-bottom: 15px;
    }

    .app-form-group.message {
        margin-top: 40px;
    }

    .app-form-group.buttons {
        margin-bottom: 0;
        text-align: right;
    }

    .app-form-control {
        width: 100%;
        padding: 10px 0;
        background: none;
        border: none;
        border-bottom: 1px solid #666;
        color: #ddd;
        font-size: 14px;
        text-transform: uppercase;
        outline: none;
        transition: border-color .2s;
    }

    .app-form-control::placeholder {
        color: #666;
    }

    .app-form-control:focus {
        border-bottom-color: #ddd;
    }

    .app-form-button {
        background: none;
        border: none;
        color: #ea1d6f;
        font-size: 14px;
        cursor: pointer;
        outline: none;
    }

    .app-form-button:hover {
        color: #b9134f;
    }

    .credits {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        color: #ffa4bd;
        font-family: 'Roboto Condensed', sans-serif;
        font-size: 16px;
        font-weight: normal;
    }

    .credits-link {
        display: flex;
        align-items: center;
        color: #fff;
        font-weight: bold;
        text-decoration: none;
    }

    .dribbble {
        width: 20px;
        height: 20px;
        margin: 0 5px;
    }

    @media (max-width: 1080px) {
        .container {
            flex: 0 1 90%;
        }

        .screen-body-item {
            padding: 20px;
        }

        .app-title {
            font-size: 20px;
        }

        iframe {
            display: none;
        }
    }


    @media screen and (max-width: 520px) {
        .screen-body {
            flex-direction: column;
        }

        .screen-body-item.left {
            margin-bottom: 30px;
        }

        .app-title {
            flex-direction: row;
        }

        .app-title span {
            margin-right: 12px;
        }

        .app-title:after {
            display: none;
        }
    }

    @media screen and (max-width: 600px) {
        .screen-body {
            padding: 40px;
        }

        .screen-body-item {
            padding: 0;
        }
    }
</style>
<title>MFA Customs Brokerage</title>

<div class="background">
    <div class="container">
        <div class="screen">
            <div class="screen-header">
                <div class="screen-header-left">
                    <div class="screen-header-button close"></div>
                    <div class="screen-header-button maximize"></div>
                    <div class="screen-header-button minimize"></div>
                </div>
                <div class="screen-header-right">
                    <div class="screen-header-ellipsis"></div>
                    <div class="screen-header-ellipsis"></div>
                    <div class="screen-header-ellipsis"></div>
                </div>
            </div>
            <div class="screen-body">
                <div class="screen-body-item left">
                    <div class="app-title">
                        <span>Get In Touch with Us</span>
                    </div>
                    <div class="app-contact">Address : Rm. 450 4/F Padilla Delos Reyes Bldg. 232 Juan Luna St., Binondo,
                        Manila</div>
                    <div class="app-contact">CONTACT INFO : +82 887 706</div>
                    <div class="app-contact"><iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.0226367189885!2d120.97308531484012!3d14.597785989804198!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ca0e6a3284fb%3A0x12764225cff73e4a!2sPadilla%20-%20De%20Los%20Reyes%20Bldg.!5e0!3m2!1sen!2sph!4v1679393234249!5m2!1sen!2sph"
                            style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe></div>
                </div>
                <div class="screen-body-item">
                    <form method="POST" action="{{ route('sendFeedback') }}">
                        @csrf
                        <div class="app-form">
                            <div class="app-form-group">
                                <input type="text" class="app-form-control" name="name" placeholder="NAME">
                            </div>
                            <div class="app-form-group">
                                <input type="email" class="app-form-control" name="email" placeholder="EMAIL">
                            </div>
                            <div class="app-form-group">
                                <input type="number" class="app-form-control" name="contact" placeholder="CONTACT NO">
                            </div>
                            <div class="app-form-group message">
                                <textarea name="message" class="app-form-control" placeholder="MESSAGE"></textarea>
                            </div>
                            <div class="app-form-group buttons">
                                <button type="submit" class="app-form-button">SEND</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    function addClass() {
        document.body.classList.add("sent");
    }

    sendLetter.addEventListener("click", addClass);
</script>
