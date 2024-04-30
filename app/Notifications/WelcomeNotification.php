<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('Welcome to Our Platform!')
            ->greeting('Hello ' . $this->user->name . '!')
            ->line('Welcome to our platform. We are excited to have you on board!')
            ->line('Thank you for registering with us.')
            ->line('If you have any questions or need assistance, feel free to contact us.')
            ->action('Go to Dashboard', url('/dashboard'))
            ->line('Enjoy your time on our platform!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
