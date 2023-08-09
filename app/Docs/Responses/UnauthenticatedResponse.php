<?php 

namespace App\Docs\Responses;

use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class UnauthenticatedResponse extends OA\Response
{
    public function __construct() {
        parent::__construct(
            response: 401,
            description: 'Unauthenticated',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: 'message',
                        type: 'string',
                        example: 'Unauthenticated.',
                    ),
                ],
            ),
        );
    }
}
