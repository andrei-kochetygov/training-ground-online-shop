<?php 

namespace App\Docs\Http\Responses;

use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Response;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class UnprocessableEntity extends Response
{
    public function __construct(...$examples) {
        $properties = collect($examples)->map(function ($example, $property) {
            return new Property(
                property: $property,
                example: $example,
            );
        })->toArray();

        parent::__construct(
            response: 422,
            description: 'Unprocessable Entity (Validation Errors)',
            content: new JsonContent(
                properties: [
                    new Property(
                        property: 'message',
                        example: 'The given data was invalid.',
                    ),
                    new Property(
                        property: 'errors',
                        properties: $properties,
                    ),
                ],
            ),
        );
    }
}
