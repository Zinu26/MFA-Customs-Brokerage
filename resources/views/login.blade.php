@include('layouts.inc.header')
@include('layouts.inc.topbarNav')

<link rel="stylesheet" href="/css/login.css">
<title>MFA Customs Brokerage</title>

<div class="box">
    <span class="borderLine"></span>
    <form action="{{ route('login.submit') }}" method="POST" autocomplete="off">
        @csrf
        <h3>
            <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
            <lord-icon
                src="https://cdn.lordicon.com/ajkxzzfb.json"
                trigger="loop"
                delay="2000"
                colors="primary:#b4b4b4,secondary:#4bb3fd"
                style="width:50px;height:50px">
            </lord-icon>
        </h3>
        <h2>Sign in</h2>
        <div class="inputBox">
            <input type="text" name="username" id="username" required="required" class="@error('username') is-invalid @enderror">
            <span>Username</span>
            <i></i>
            @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="inputBox">
            <input type="password" name="password" class="@error('password') is-invalid @enderror" id="password" required="required">
            <span>Password</span>
            <i></i>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="links">
            <a href="#">Forgot Password</a>
        </div>
        <input type="submit" name="login" value="Login">
    </form>
</div>
