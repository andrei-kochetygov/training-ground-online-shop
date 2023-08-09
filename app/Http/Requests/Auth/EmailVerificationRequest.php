<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Auth\EmailVerificationRequest as EmailVerificationRequestBase;

class EmailVerificationRequest extends EmailVerificationRequestBase
{
    public function authorize()
    {
        if (! hash_equals((string) $this->user()->getKey(),
                          (string) $this->get('id'))) {
            return false;
        }

        if (! hash_equals(sha1($this->user()->getEmailForVerification()),
                          (string) $this->get('hash'))) {
            return false;
        }

        return true;
    }
}
