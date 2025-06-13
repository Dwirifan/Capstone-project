<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use URL;

class VerifyPendingUser extends Notification
{
    use Queueable;

    protected $pendingUser;

    public function __construct($pendingUser)
    {
        $this->pendingUser = $pendingUser;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

   public function toMail($notifiable)
{
    $verifyUrl = URL::temporarySignedRoute(
        'verification.verify',
        Carbon::now()->addMinutes(60),
        ['id' => $this->pendingUser->id, 'email' => $this->pendingUser->email]
    );

    return (new MailMessage)
        ->subject('Verifikasi Email')
        ->greeting('Halo ' . $this->pendingUser->name)
        ->line('Silakan klik tombol di bawah ini untuk memverifikasi email Anda.')
        ->action('Verifikasi Email', $verifyUrl)
        ->line('Jika Anda tidak mendaftar, abaikan email ini.');
}
}