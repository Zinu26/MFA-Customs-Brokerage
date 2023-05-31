<header>
    <link rel="icon" href="images/logo_1.png" type="image/x-icon" />
    <title>OTP VERIFICATION | MFA Customs Brokerage</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: -300px;
            background-image: url('/images/cover.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            box-shadow: inset 0px 4px 4px rgba(0, 0, 0, 0.25);
        }

        :where(.container, form, .input-field, header) {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: #fff;
            padding: 30px 65px;
            border-radius: 12px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            background: #1b8d4b;
        }

        .container header {
            height: 65px;
            width: 65px;
            background: #4070f4;
            color: #fff;
            font-size: 2.5rem;
            border-radius: 50%;
        }

        .container h4 {
            font-size: 1.25rem;
            color: #333;
            font-weight: 600;
        }

        form .input-field {
            flex-direction: row;
            column-gap: 10px;
        }

        .input-field input {
            height: 45px;
            width: 42px;
            border-radius: 6px;
            outline: none;
            font-size: 1.125rem;
            text-align: center;
            border: 1px solid #ddd;
        }

        .input-field input::-webkit-inner-spin-button,
        .input-field input::-webkit-outer-spin-button {
            display: none;
        }

        form button {
            margin-top: 25px;
            width: 100%;
            background: #4070f4;
            color: #fff;
            font-size: 1rem;
            border: none;
            padding: 9px 0;
            cursor: pointer;
            border-radius: 6px;
            pointer-events: none;
            background: #6e93f7;
            transition: all 0.2s ease;

        }

        form button.active {
            background: #4070f4;
            pointer-events: auto;
        }

        form button:hover {
            background: #0e4bf1;

        }

        form input {
            height: 45px;
            width: 100%;
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        @media only screen and (max-width: 1080px) {
            .container {
                padding: 20px;
            }

            form .input-field {
                flex-direction: column;
                row-gap: 10px;
            }

            form button {
                margin-top: 20px;
            }
        }
    </style>
</header>

<div class="container">
    <header>
        <i class="fa fa-shield"></i>
    </header>
    <h4>Enter OTP Code</h4>
    <form action="{{ route('submit.otp') }}" method="post">
        @csrf
        <div class="form-group">
            <input type="number" name="token" class="form-control" id="otp-input" placeholder="Enter OTP">
        </div>
        <button type="submit" class="active" id="verify-button">Verify OTP</button>
    </form>
</div>

<script>
    const otpInput = document.getElementById('otp-input');
    const verifyButton = document.getElementById('verify-button');

    otpInput.addEventListener('input', function() {
        if (otpInput.value.trim() === '') {
            verifyButton.disabled = true;
        } else {
            verifyButton.disabled = false;
        }
    });
</script>
