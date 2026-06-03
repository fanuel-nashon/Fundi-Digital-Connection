<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountRejectedNotification extends Notification
{
    public function __construct(public ?string $reason = null) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Update on Your Fundi Digital Account Application')
            ->greeting("Hello {$notifiable->name},")
            ->line('Thank you for your interest in joining **Fundi Digital Connection**.')
            ->line('After reviewing your application, we are unable to approve your account at this time.');

        if ($this->reason) {
            $message->line("**Reason:** {$this->reason}");
        }

        return $message
            ->line('If you believe this is an error or would like to reapply, please contact us.')
            ->line('Thank you for your understanding.');
    }
}
