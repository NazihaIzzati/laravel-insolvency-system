# Email Configuration for Password Reset Feature

## Overview
The password reset email functionality has been successfully added to the user management system. This feature allows administrators to send password reset emails to users with temporary passwords.

## Features Added

### 1. Password Reset Email Functionality
- **Location**: User Management Edit Page (`/user-management/{user}/edit`)
- **Quick Access**: User Management Index Page (Reset button for each user)
- **Route**: `POST /user-management/{user}/send-password-reset`

### 2. Email Template
- **Location**: `resources/views/emails/password-reset.blade.php`
- **Features**: Professional HTML email template with security information

### 3. Notification Class
- **Location**: `app/Notifications/PasswordResetNotification.php`
- **Features**: Handles email sending with temporary password

### 4. Mail Configuration
- **Location**: `config/mail.php`
- **Features**: Laravel mail configuration for SMTP

## Configuration Required

To enable email functionality, add these settings to your `.env` file:

```env
# Email Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Insolvency Information System"
```

### Gmail Configuration Example
1. Enable 2-Factor Authentication on your Gmail account
2. Generate an App Password for the application
3. Use the App Password in `MAIL_PASSWORD`

### Other Email Providers
- **Outlook/Hotmail**: Use `smtp-mail.outlook.com` with port 587
- **Yahoo**: Use `smtp.mail.yahoo.com` with port 587
- **Custom SMTP**: Configure according to your provider's settings

## How to Use

### For Administrators:
1. Navigate to User Management (`/user-management`)
2. Find the user you want to reset password for
3. Click "Reset" button (if user has email) or go to Edit page
4. Click "Send Reset Email" button
5. Confirm the action
6. User will receive email with temporary password

### For Users:
1. Check email for password reset notification
2. Use the temporary password to log in
3. Change password immediately after login

## Security Features

- **Temporary Password**: 12-character secure password with mixed characters
- **Audit Logging**: All password reset actions are logged
- **Email Validation**: Only users with email addresses can receive reset emails
- **Confirmation Dialog**: Prevents accidental password resets
- **Secure Template**: Professional email template with security warnings

## Files Modified/Created

### New Files:
- `config/mail.php` - Mail configuration
- `app/Notifications/PasswordResetNotification.php` - Email notification
- `resources/views/emails/password-reset.blade.php` - Email template
- `EMAIL_CONFIGURATION.md` - This documentation

### Modified Files:
- `app/Http/Controllers/UserManagementController.php` - Added sendPasswordResetEmail method
- `routes/web.php` - Added password reset route
- `resources/views/user-management/edit.blade.php` - Added password reset UI
- `resources/views/user-management/index.blade.php` - Added quick reset button

## Testing

To test the functionality:
1. Configure email settings in `.env`
2. Ensure a user has an email address
3. Navigate to user management
4. Click "Reset" or "Send Reset Email"
5. Check email inbox for the password reset notification

## Troubleshooting

### Common Issues:
1. **Email not sending**: Check SMTP configuration and credentials
2. **User has no email**: Add email address to user profile first
3. **Permission denied**: Ensure user has proper role permissions
4. **Template not found**: Clear view cache with `php artisan view:clear`

### Debug Steps:
1. Check Laravel logs in `storage/logs/laravel.log`
2. Test SMTP connection with `php artisan tinker`
3. Verify email configuration with `php artisan config:cache`
