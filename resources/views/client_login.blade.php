@include('layouts.inc.header')
@include('layouts.inc.topbarNav')
@include('layouts.inc.message')
<link rel="stylesheet" href="/css/style.css" />
<link rel="stylesheet" href="/css/login.css">
<title>MFA Customs Brokerage</title>

<div class="box">
    <span class="borderLine"></span>
    <form action="{{ route('submit.login.client') }}" method="POST"
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
        <h2>Client Sign in</h2>
        <div class="inputBox @error('email') is-invalid @enderror">
            <input type="email" name="email" id="email" required="required" value="{{ old('email') }}">
            <span>Email</span>
            <i></i>
            @error('email')
                <span class="error-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="inputBox @error('tin') is-invalid @enderror">
            <input type="text" name="tin" id="tin" required="required" value="{{ old('tin') }}">
            <span>Tin</span>
            <i></i>
            @error('tin')
                <span class="error-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="links">
            <a href="{{route('login')}}">Login as Company</a>
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
