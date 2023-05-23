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
            
        </div>
        <div class="links">
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
