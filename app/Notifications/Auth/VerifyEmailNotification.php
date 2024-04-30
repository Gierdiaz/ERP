<?php

namespace App\Notifications\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\{Log, Storage};

class VerifyEmailNotification extends Notification
{
    use Queueable;

    protected $user;

    protected $photo;

    public function __construct(User $user, $photo)
    {
        $this->user  = $user;
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
            $avatarPath     = Storage::disk('public')->url($this->photo);
            $avatarName     = basename($this->photo);
            $avatarData     = Storage::disk('public')->get($this->photo);
            $avatarMimeType = Storage::disk('public')->mimeType($this->photo);

            return (new MailMessage())
                ->subject('Verify New User Email Address')
                ->markdown('emails.auth.verify_email', [
                    'user'            => $this->user,
                    'avatarPath'      => $avatarPath,
                    'verificationUrl' => $verificationUrl,
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
