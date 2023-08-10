<?php 

namespace App\Docs\Http\Responses;

use OpenApi\Attributes\Response;
use OpenApi\Attributes\Header;
use OpenApi\Attributes\Schema;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Found extends Response
{
    public function __construct($location) {
        parent::__construct(
            response: 302,
            description: 'Found',
            headers: [
                new Header(
                    header: 'Location',
                    schema: new Schema(
                        example: $location,
                    ),
                ),
            ],
        );
    }
}
