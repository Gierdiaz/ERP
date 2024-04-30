<?php

namespace App\Notifications\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $photo;

    public function __construct(User $user, $photo)
    {
        $this->user = $user;
        $this->photo = $photo;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);
    
        if (Storage::disk('public')->exists($this->photo)) {
            $avatarContents = Storage::disk('public')->get($this->photo);
            $avatarName = basename($this->photo);
    
            return (new MailMessage())
                ->subject('Verify New User Email Address')
                ->line('A new user has registered on your website and needs email verification.')
                ->line('Name: ' . $this->user->name)
                ->line('Email: ' . $this->user->email)
                ->action('Verify Email Address', $verificationUrl)
                ->line('If you did not create an account, no further action is required.')
                ->attachData($avatarContents, $avatarName, [
                    'mime' => Storage::disk('public')->mimeType($this->photo),
                ]);
        } else {
            Log::channel('error')->error('Avatar file does not exist: ' . $this->photo);
        }
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
