<?php

return [

    'url' => env('FRONTEND_URL', 'http://localhost:3000'),

    'paths' => [
        'email_verification' => env('FRONTEND_EMAIL_VERIFICATION_PATH', '/verify-email'),
        'reset_password' => env('FRONTEND_RESET_PASSWORD_PATH', '/reset-password'),
    ],

];
