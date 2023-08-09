<?php 

namespace App\Docs;

use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_METHOD)]
class JsonBody extends OA\RequestBody
{
    public function __construct(...$examples) {
        $properties = collect($examples)->map(function ($example, $property) {
            return new OA\Property(
                property: $property,
                type: gettype($example),
                example: $example,
            );
        })->toArray();

        parent::__construct(
            required: true,
            content: new OA\JsonContent(
                properties: $properties,
            ),
        );
    }
}
