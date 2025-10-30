<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Reset Password</title>
</head>
<body>
    <p>Halo,</p>
    <p>Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.</p>
    <p>Gunakan Kode OTP di bawah ini untuk mereset password Anda:</p>
    
    <h1 style="font-size: 32px; letter-spacing: 5px; text-align: center; margin: 20px 0;">
        {{ $otp }}
    </h1>
    
    <p>Kode OTP ini akan kedaluwarsa dalam 10 menit.</p>
    <p>Jika Anda tidak merasa meminta reset password, abaikan email ini.</p>
    <br>
    <p>Terima kasih,</p>
    <p>Tim TB Pusat</p>
</body>
</html>