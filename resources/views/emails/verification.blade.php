<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white !important;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #45a049;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .link-text {
            word-break: break-all;
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hello {{ $userName }}!</h2>
        <p>Thank you for registering. Please verify your email address by clicking the button below:</p>
        
        <a href="{{ $verificationUrl }}" class="button">Verify Email Address</a>
        
        <p>Or copy and paste this link into your browser:</p>
        <p class="link-text">{{ $verificationUrl }}</p>
        
        <p><strong>Note:</strong> This verification link will remain valid until you verify your account.</p>
        
        <div class="footer">
            <p>If you did not create an account, no further action is required.</p>
            <p>Thank you,<br>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
