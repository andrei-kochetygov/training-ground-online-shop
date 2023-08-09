<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;

class PasswordResetNotification extends ResetPassword
{
    protected function resetUrl($notifiable)
    {
        $queryParameters = http_build_query([
            'token' => $this->token,
            'email' => $notifiable->email,
        ]);

        return config('frontend.url') . config('frontend.paths.reset_password') . '?' . $queryParameters;
    }
}
