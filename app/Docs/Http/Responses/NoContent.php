<?php 

namespace App\Docs\Http\Responses;

use OpenApi\Attributes\Response;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class NoContent extends Response
{
    public function __construct() {
        parent::__construct(
            response: 204,
            description: 'No Content',
        );
    }
}
