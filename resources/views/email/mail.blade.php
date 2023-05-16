<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <p>You are receiving this email because you recently logged in your account
        in MFA's website and needs Two-Factor Authentication to continue. Provided below
        is the OTP. If you did not request this, then you may ignore this email.<br><br>
    </p>
    <p>User requested name: {{ $get_user_name }}</p>
    <h3>OTP: {{ $validToken }}</h3>
</body>
</html>
