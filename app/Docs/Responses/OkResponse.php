<?php 

namespace App\Docs\Responses;

use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class OkResponse extends OA\Response
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
            response: 200,
            description: 'OK',
            content: new OA\JsonContent(
                properties: $properties,
            ),
        );
    }
}
