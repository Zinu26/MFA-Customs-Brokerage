@include('layouts.inc.header')
@include('layouts.inc.topbarNav')
@include('layouts.inc.message')

<link rel="stylesheet" href="/css/login.css">
<title>MFA Customs Brokerage</title>

<div class="box">
    <span class="borderLine"></span>
    <form action="{{ route(session()->has('2fa:user:id') ? 'submit.2fa' : 'submit.login') }}" method="POST"
        autocomplete="off">
        @csrf
        @if (session()->has('2fa:user:id'))
            <div class="inputBox @error('one_time_password') is-invalid @enderror">
                <input type="text" name="one_time_password" id="one_time_password" required="required"
                    value="{{ old('one_time_password') }}">
                <span>2FA Code</span>
                <i></i>
                @error('one_time_password')
                    <span class="error-feedback">{{ $message }}</span>
                @enderror
            </div>
        @endif
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
            {{-- <a href="#">Forgot Password</a> --}}
            <a href="{{route('login.client')}}">Login as Client</a>
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
