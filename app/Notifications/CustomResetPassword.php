<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as BaseNotification;

class CustomResetPassword extends BaseNotification
{
    public function toMail($notifiable)
    {
       $frontendUrl = config('app.frontend_url');
        $url = $frontendUrl . '/autentikasi/reset?token=' . $this->token . '&email=' . urlencode($notifiable->email);

        return (new MailMessage)
            ->subject('Reset Password')
            ->line('Klik tombol di bawah untuk mengatur ulang password Anda.')
            ->action('Reset Password', $url)
            ->line('Abaikan email ini jika Anda tidak meminta reset password.');
    }
}
