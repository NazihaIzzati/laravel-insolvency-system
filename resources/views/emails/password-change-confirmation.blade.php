<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Successfully Changed - Insolvency Information System</title>
    <style>
        /* Basic Reset */
        body, p, h1, h2, h3, h4, h5, h6 { margin: 0; padding: 0; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; background-color: #f4f4f4; color: #333; }
        table { border-collapse: collapse; width: 100%; }
        td, th { padding: 0; }
        img { max-width: 100%; border: none; }
        a { text-decoration: none; color: #007bff; }

        /* Main Container */
        .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); overflow: hidden; }

        /* Header */
        .header { background-color: #059669; padding: 20px; text-align: center; color: #ffffff; }
        .header h1 { font-size: 24px; margin-bottom: 5px; }
        .header p { font-size: 14px; opacity: 0.9; }

        /* Content Area */
        .content { padding: 30px; line-height: 1.6; font-size: 15px; color: #555; }
        .content h2 { font-size: 20px; color: #333; margin-bottom: 15px; }
        .content p { margin-bottom: 15px; }
        .content strong { color: #333; }

        /* Success Box */
        .success-box { background-color: #f0fdf4; border: 1px solid #bbf7d0; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center; }
        .success-box h3 { color: #059669; margin-bottom: 10px; font-size: 18px; }
        .success-box p { color: #166534; margin: 0; }

        /* Info Section */
        .info-section { background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; margin: 20px 0; }
        .info-section h4 { margin: 0 0 10px 0; color: #92400e; }
        .info-section ul { margin: 0; padding-left: 20px; }
        .info-section li { margin-bottom: 5px; }

        /* Button */
        .button { display: inline-block; background-color: #dc2626; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; margin: 20px 0; }
        .button:hover { background-color: #b91c1c; }

        /* Footer */
        .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; text-align: center; color: #6b7280; font-size: 14px; }
        .warning { background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; padding: 15px; margin: 20px 0; color: #dc2626; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div style="font-size: 28px; font-weight: bold; color: #ffffff; letter-spacing: 1px;">Insolvency Information System</div>
            <h1 style="margin-top: 10px;">Password Successfully Changed</h1>
        </div>

        <div class="content">
            <p>Hello <strong>{{ $user->name }}</strong>,</p>

            <div class="success-box">
                <h3>✅ Password Change Confirmed</h3>
                <p>Your password has been successfully updated and is now active.</p>
            </div>

            <div class="info-section">
                <h4>Change Details:</h4>
                <ul>
                    <li><strong>Changed by:</strong> {{ $changedBy }}</li>
                    <li><strong>Change time:</strong> {{ $changeTime->format('F j, Y \a\t g:i A') }}</li>
                    <li><strong>Method:</strong> 
                        @if($changeMethod === 'reset_link')
                            Password Reset Link
                        @elseif($changeMethod === 'admin_change')
                            Administrator Change
                        @else
                            Self-Service Change
                        @endif
                    </li>
                    <li><strong>Account:</strong> {{ $user->email }}</li>
                </ul>
            </div>

            <p>You can now log in to your account using your new password. For security reasons, all existing sessions have been terminated.</p>

            <div style="text-align: center;">
                <a href="{{ $loginUrl }}" class="button">Log In to Your Account</a>
            </div>

            <div class="warning">
                <strong>Security Notice:</strong> If you did not request this password change, please contact your system administrator immediately and change your password again.
            </div>

            <div class="footer">
                <p>This is an automated message from the Insolvency Information System.</p>
                <p>Please do not reply to this email.</p>
                <p><strong>Best regards,<br>System Administration Team</strong></p>
            </div>
        </div>
    </div>
</body>
</html>
