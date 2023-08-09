<?php 

namespace App\Docs;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class SecuritySchemas
{
    public function __construct(
        public $schemas = [],
    ) {
        app()->bind(SecuritySchemas::class, function() use ($schemas) {
            return collect($schemas)->map(function($schema) {
                return [$schema => []];
            })->toArray();
        });
    }
}
