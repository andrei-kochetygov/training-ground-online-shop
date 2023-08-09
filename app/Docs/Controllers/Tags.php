<?php 

namespace App\Docs\Controllers;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Tags
{
    public function __construct(
        public $names = [],
    ) {
        app()->bind(Tags::class, function() use ($names) {
            return $names;
        });
    }
}
