<?php 

namespace App\Docs\Http\Responses;

use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Response;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Created extends Response
{
    public function __construct(...$examples) {
        $properties = collect($examples)->map(function ($example, $property) {
            return new Property(
                property: $property,
                type: \gettype($example) === 'string' ? 'string' : null,
                example: $example,
            );
        })->toArray();

        parent::__construct(
            response: 201,
            description: 'Created',
            content: new JsonContent(
                properties: $properties,
            ),
        );
    }
}
