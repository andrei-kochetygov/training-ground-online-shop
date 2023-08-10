<?php 

namespace App\Docs\Http\Methods;

use App\Docs\Http\MethodTrait;
use OpenApi\Attributes as OpenApi;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Put extends OpenApi\Put
{
    use MethodTrait;
}
