<?php 

namespace App\Docs\Http\Requests;

use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\RequestBody;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Json extends RequestBody
{
    public function __construct(...$examples) {
        $properties = collect($examples)->map(function ($example, $property) {
            return new Property(
                property: $property,
                example: $example,
            );
        })->toArray();

        parent::__construct(
            required: true,
            content: new JsonContent(
                properties: $properties,
            ),
        );
    }
}
