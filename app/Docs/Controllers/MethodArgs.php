<?php 

namespace App\Docs\Controllers;

use App\Docs\Controllers\Tags;
use App\Docs\SecuritySchemas;

class MethodArgs
{
    public static function get($args) {
        $tags = (array) (clone collect(app(Tags::class)))->toArray();
        $security = (array) (clone collect(app(SecuritySchemas::class)))->toArray();

        $modifiedArgs = array_merge($args, compact('tags', 'security'));

        app()->offsetUnset(SecuritySchemas::class);

        return $modifiedArgs;
    }
}
