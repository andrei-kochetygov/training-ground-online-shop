<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;

class EmailVerificationNotification extends VerifyEmail
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        $queryParameters = parse_url($verificationUrl, PHP_URL_QUERY);

        $frontendVerificationUrl = config('frontend.url') . config('frontend.paths.email_verification') . '?' . $queryParameters;

        return $this->buildMailMessage($frontendVerificationUrl);
    }
}
