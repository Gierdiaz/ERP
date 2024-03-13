<?php

namespace App\Notifications\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage())
            ->subject('Verify New User Email Address')
            ->line('A new user has registered on your website and needs email verification.')
            ->line('Name: ' . $this->user->name)
            ->line('Email: ' . $this->user->email)
            ->action('Verify Email Address', $verificationUrl)
            ->line('If you did not create an account, no further action is required.');
    }

    protected function verificationUrl(object $notifiable): string
    {
        return url(route('verification.verify', [
            'id'   => $notifiable->getKey(),
            'hash' => sha1($notifiable->getEmailForVerification()),
        ]));
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
