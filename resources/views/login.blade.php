@include('layouts.inc.header')
@include('layouts.inc.topbarNav')
@include('layouts.inc.message')
<link rel="stylesheet" href="/css/style.css" />
<link rel="stylesheet" href="/css/login.css">
<title>MFA Customs Brokerage</title>

<style>
    .notification {
        position: fixed;
        top: 200px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1;
    }

    .notification.success {
        background-color: #5cb85c;
        /* green */
        color: #fff;
    }

    .notification.error {
        background-color: #d9534f;
        /* red */
        color: #fff;
    }

    .notification.warning {
        background-color: #f0ad4e;
        /* yellow */
        color: #fff;
    }

    .notification.hide {
        opacity: 0;
    }

    .box {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 380px;
        height: 470px;
        background: #1c1c1c;
        border-radius: 8px;
        overflow: hidden;
    }

    .box::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 380px;
        height: 420px;
        background: linear-gradient(0deg, transparent, transparent, #45f3ff, #45f3ff, #45f3ff);
        z-index: 1;
        transform-origin: bottom right;
        animation: animate 6s linear infinite;
    }

    .box::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 380px;
        height: 420px;
        background: linear-gradient(0deg, transparent, transparent, #45f3ff, #45f3ff, #45f3ff);
        z-index: 1;
        transform-origin: bottom right;
        animation: animate 6s linear infinite;
        animation-delay: -3s;
    }

    .borderLine {
        position: absolute;
        top: 0;
        inset: 0;
    }

    .borderLine::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 380px;
        height: 420px;
        background: linear-gradient(0deg, transparent, transparent, #ff2770, #ff2770, #ff2770);
        z-index: 1;
        transform-origin: bottom right;
        animation: animate 6s linear infinite;
        animation-delay: -1.5s;
    }

    .borderLine::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 380px;
        height: 420px;
        background: linear-gradient(0deg, transparent, transparent, #ff2770, #ff2770, #ff2770);
        z-index: 1;
        transform-origin: bottom right;
        animation: animate 6s linear infinite;
        animation-delay: -4.5s;
    }

    @keyframes animate {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .box form {
        position: absolute;
        top: 0;
        left: 0;
        inset: 4px;
        background: #222;
        padding: 50px 40px;
        border-radius: 8px;
        z-index: 2;
        display: flex;
        flex-direction: column;
    }

    .box form h3 {
        text-align: center;
    }

    .box form h2 {
        color: #fff;
        font-weight: 500;
        text-align: center;
        letter-spacing: 0.1em;
    }

    .box form .inputBox {
        position: relative;
        width: 300px;
        margin-top: 35px;
    }

    .box form .inputBox input {
        position: relative;
        width: 100%;
        padding: 10px 10px 10px;
        background: transparent;
        outline: none;
        border: none;
        box-shadow: none;
        color: #23242a;
        font-size: 1em;
        letter-spacing: 0.05em;
        transition: 0.5s;
        z-index: 10;
    }

    .box form .inputBox span {
        position: absolute;
        left: 0;
        padding: 20px 10px 10px;
        pointer-events: none;
        color: #8f8f8f;
        font-size: 1em;
        letter-spacing: 0.05em;
        transition: 0.5s;
    }

    .box form .inputBox input:valid~span,
    .box form .inputBox input:focus~span {
        color: #fff;
        font-size: 0.75em;
        transform: translateY(-34px);
    }

    .box form .inputBox i {
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 2px;
        background: #fff;
        border-radius: 4px;
        overflow: hidden;
        transition: 0.5s;
        pointer-events: none;
    }

    .box form .inputBox input:valid~i,
    .box form .inputBox input:focus~i {
        height: 44px;
    }

    .box form .links {
        display: flex;
        justify-content: space-between;
    }

    .box form .links a {
        margin: 10px 0;
        font-size: 0.75em;
        color: #8f8f8f;
        text-decoration: none;
    }

    .box form .links a:hover,
    .box form .links a:nth-child(2) {
        color: #fff;
    }

    .box form input[type="submit"] {
        border: none;
        outline: none;
        padding: 9px 25px;
        background: #fff;
        cursor: pointer;
        font-size: 0.9em;
        border-radius: 4px;
        font-weight: 600;
        width: 100px;
        margin-top: 10px;
    }

    .box form input[type="submit"]:active {
        opacity: 0.8;
    }

    .error-message {
        display: none;
        background-color: #f44336;
        color: white;
        padding: 10px;
        margin: 10px 10px 10px;
        font-size: 10px;
    }

    .error-message p {
        margin: 0;
    }

    @media only screen and (max-width: 991px) {
        .notification {
            position: fixed;
            top: 160px;
            left: 50%;
            transform: translateX(-50%);
        }
    }

    @media only screen and (max-width: 1080px) {
        .notification {
            position: fixed;
            top: 85px;
        }

        .box {
            width: 90%;
            height: auto;
            width: 280px;
            height: 370px;
            text-align: center;
        }

        .box::before,
        .box::after,
        .borderLine::before,
        .borderLine::after {
            width: 90%;
            height: 300px;
        }

        .box form {
            padding: 30px 20px;
        }

        .box form .inputBox {
            width: 100%;
        }

        .box form input[type="submit"] {
            padding: 0px 25px;
        }
    }
</style>
<div>
    @if (session()->has('success'))
        <div class="notification success" id="notification">
            <i class="fa-sharp fa-solid fa-circle-check"></i> {{ session()->get('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="notification error" id="notification">
            <i class="fa-sharp fa-solid fa-circle-exclamation"></i> {{ session()->get('error') }}
        </div>
    @endif

    @if (session()->has('warning'))
        <div class="notification warning" id="notification">
            <i class="fa-sharp fa-solid fa-triangle-exclamation"></i> {{ session()->get('warning') }}
        </div>
    @endif
</div>

<div class="box">
    <span class="borderLine"></span>
    <form action="{{ route('submit.login') }}" method="POST" autocomplete="off">
        @csrf

        <h3>
            <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
            <lord-icon src="https://cdn.lordicon.com/ajkxzzfb.json" trigger="loop" delay="2000"
                colors="primary:#b4b4b4,secondary:#4bb3fd" style="width:50px;height:50px">
            </lord-icon>
        </h3>
        <h2>Sign in</h2>
        <div class="inputBox @error('username') is-invalid @enderror">
            <input type="text" name="username" id="username" required="required" value="{{ old('username') }}">
            <span>Username</span>
            <i></i>
            @error('username')
                <span class="error-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="inputBox @error('password') is-invalid @enderror">
            <input type="password" name="password" id="password" required="required" value="{{ old('password') }}">
            <span>Password</span>
            <i></i>
            @error('password')
                <span class="error-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="links">
            <a href="{{ route('forgot-password') }}">Forgot Password</a>
            <a href="{{ route('login.client') }}"><strong><u>Login as Client</u></strong></a>
        </div>
        <input type="submit" name="login" value="Login">
    </form>
</div>

<!-- Add this JavaScript to set focus on the first input field with an error -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const firstInvalidInput = document.querySelector('.inputBox.is-invalid input');
        if (firstInvalidInput) {
            firstInvalidInput.focus();
        }
    });
</script>
