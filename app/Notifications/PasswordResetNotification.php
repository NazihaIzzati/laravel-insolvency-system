<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class PasswordResetNotification extends Notification
{
    use Queueable;

    protected $resetToken;
    protected $resetBy;

    /**
     * Create a new notification instance.
     *
     * @param string $resetToken
     * @param string $resetBy
     */
    public function __construct($resetToken, $resetBy)
    {
        $this->resetToken = $resetToken;
        $this->resetBy = $resetBy;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Generate the reset URL with the correct base URL for development
        $baseUrl = config('app.url');
        if (str_contains($baseUrl, 'localhost')) {
            $baseUrl = 'http://127.0.0.1:8000';
        }
        
        $resetUrl = $baseUrl . '/password/reset?' . http_build_query([
            'token' => $this->resetToken, 
            'email' => $notifiable->email
        ]);
        
        return (new MailMessage)
            ->subject('Password Reset - Insolvency Information System')
            ->view('emails.password-reset', [
                'user' => $notifiable,
                'resetUrl' => $resetUrl,
                'resetBy' => $this->resetBy
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Your password has been reset by ' . $this->resetBy,
            'reset_date' => now()->toISOString(),
        ];
    }
}
