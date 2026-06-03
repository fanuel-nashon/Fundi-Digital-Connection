<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountApprovedNotification extends Notification
{
    public function __construct(public string $tempPassword) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Fundi Digital Account Has Been Approved')
            ->greeting("Hello {$notifiable->name}!")
            ->line('Great news — your account on **Fundi Digital Connection** has been reviewed and approved.')
            ->line('Here are your login credentials:')
            ->line("**Email:** {$notifiable->email}")
            ->line("**Temporary Password:** `{$this->tempPassword}`")
            ->action('Login Now', url('/'))
            ->line('For your security, please change your password after your first login.')
            ->line('Welcome to Fundi Digital Connection!');
    }
}
