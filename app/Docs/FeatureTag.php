<?php 

namespace App\Docs;

#[\Attribute(\Attribute::TARGET_CLASS)]
class FeatureTag
{
    public function __construct($tag) {
        app()->bind(FeatureTag::class, function() use ($tag) {
            return $tag;
        });
    }
}
