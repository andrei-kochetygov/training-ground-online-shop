<?php 

namespace App\Docs\Responses;

use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class NoContentResponse extends OA\Response
{
    public function __construct() {
        parent::__construct(
            response: 204,
            description: 'No content',
        );
    }
}
