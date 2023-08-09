<?php 

namespace App\Docs\Controllers\Methods;

use App\Docs\Controllers\MethodArgs;
use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Patch extends OA\Patch
{
    public function __construct(...$args)
    {
        $methodArgs = MethodArgs::get($args);

        parent::__construct(...$methodArgs);
    }
}
