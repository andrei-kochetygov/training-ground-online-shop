<?php 

namespace App\Docs\Http\Responses;

use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Response;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Unauthenticated extends Response
{
    public function __construct() {
        parent::__construct(
            response: 401,
            description: 'Unauthenticated',
            content: new JsonContent(
                properties: [
                    new Property(
                        property: 'message',
                        example: 'Unauthenticated.',
                    ),
                ],
            ),
        );
    }
}
