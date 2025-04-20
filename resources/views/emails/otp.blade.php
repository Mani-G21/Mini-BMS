<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your OTP Code</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f8fa;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 480px;
            margin: 40px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
            text-align: center;
        }
        .otp-box {
            display: inline-block;
            background-color: #f0f0f0;
            color: #2c3e50;
            font-size: 32px;
            font-weight: bold;
            padding: 16px 32px;
            border-radius: 10px;
            letter-spacing: 6px;
            margin-top: 20px;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>👋 Hello!</h2>
        <p>Use the OTP below to complete your login or registration:</p>

        <div class="otp-box">
            {{ $otp }}
        </div>
        <p style="margin-top: 20px;">This OTP will expire in 5 minutes. Please do not share it with anyone.</p>

        <div class="footer">
            <p>&mdash; Mini BookMyShow Team</p>
        </div>
    </div>
</body>
</html>
