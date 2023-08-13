<?php 

namespace App\Docs\Http\Requests;

use OpenApi\Attributes as OpenApi;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Parameter extends OpenApi\Parameter {}
