<?php 

namespace App\Docs\Http\Responses;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class JsonWebToken extends Ok
{
    public function __construct() {
        parent::__construct(
            access_token: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9hdXRoXC9yZWdpc3RlciIsImlhdCI6MTY5MTUwMDc3OCwiZXhwIjoxNjkxNTAxMDc4LCJuYmYiOjE2OTE1MDA3NzgsImp0aSI6ImZZWml6SlN6M3ozVW9RZjUiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.2ssS5y6CGWNSgZWO5DtYTiU2v4YK-UXV7TyC_kXdknc',
            token_type: 'Bearer',
            expires_in: 5 * 60,
        );
    }
}
