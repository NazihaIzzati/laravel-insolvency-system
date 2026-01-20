<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChangeConfirmationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $changedBy;
    protected $changeMethod;

    /**
     * Create a new notification instance.
     *
     * @param string $changedBy - Who initiated the password change (admin name or 'You')
     * @param string $changeMethod - How the password was changed ('reset_link', 'admin_change', 'self_change')
     */
    public function __construct($changedBy = 'You', $changeMethod = 'reset_link')
    {
        $this->changedBy = $changedBy;
        $this->changeMethod = $changeMethod;
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
        $loginUrl = config('app.url');
        if (str_contains($loginUrl, 'localhost')) {
            $loginUrl = 'http://127.0.0.1:8000/login';
        } else {
            $loginUrl = $loginUrl . '/login';
        }

        return (new MailMessage)
            ->subject('Password Successfully Changed - Insolvency Information System')
            ->view('emails.password-change-confirmation', [
                'user' => $notifiable,
                'changedBy' => $this->changedBy,
                'changeMethod' => $this->changeMethod,
                'loginUrl' => $loginUrl,
                'changeTime' => now()
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
            'message' => 'Your password has been successfully changed',
            'changed_by' => $this->changedBy,
            'change_method' => $this->changeMethod,
            'change_time' => now()->toISOString(),
        ];
    }
}