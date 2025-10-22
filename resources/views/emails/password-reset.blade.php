<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset - Insolvency Information System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 10px;
        }
        .title {
            font-size: 20px;
            color: #1f2937;
            margin-bottom: 20px;
        }
        .password-box {
            background-color: #f3f4f6;
            border: 2px solid #d1d5db;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
            font-family: 'Courier New', monospace;
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
            letter-spacing: 1px;
        }
        .info-section {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
        }
        .info-section h4 {
            margin: 0 0 10px 0;
            color: #92400e;
        }
        .info-section ul {
            margin: 0;
            padding-left: 20px;
        }
        .info-section li {
            margin-bottom: 5px;
        }
        .button {
            display: inline-block;
            background-color: #dc2626;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #b91c1c;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
        .warning {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            color: #dc2626;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Insolvency Information System</div>
            <h1 class="title">Password Reset Notification</h1>
        </div>

        <p>Hello <strong>{{ $user->name }}</strong>,</p>

        <p>A password reset request has been initiated by <strong>{{ $resetBy }}</strong>. Click the button below to reset your password:</p>

        <div style="text-align: center;">
            <a href="{{ $resetUrl }}" class="button">Reset Your Password</a>
        </div>

        <div class="info-section">
            <h4>Important Security Information:</h4>
            <ul>
                <li><strong>Reset by:</strong> {{ $resetBy }}</li>
                <li><strong>Reset date:</strong> {{ now()->format('F j, Y \a\t g:i A') }}</li>
                <li>This reset link will expire in 1 hour</li>
                <li>You can only use this link once</li>
                <li>If you didn't request this reset, please ignore this email</li>
            </ul>
        </div>

        <div class="warning">
            <strong>Security Warning:</strong> If you did not request this password reset, please contact your system administrator immediately.
        </div>

        <div class="footer">
            <p>This is an automated message from the Insolvency Information System.</p>
            <p>Please do not reply to this email.</p>
            <p><strong>Best regards,<br>System Administration Team</strong></p>
        </div>
    </div>
</body>
</html>
