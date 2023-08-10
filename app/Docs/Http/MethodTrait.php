<?php declare(strict_types=1);

namespace App\Docs\Http;

use App\Docs\FeatureTag;
use Illuminate\Support\Arr;

trait MethodTrait
{
    public function __construct(...$args) {
        $tag = app(FeatureTag::class);

        $modifiedArgs = array_merge(Arr::except($args, ['secured']), [
            'security' => isset($args['secured']) ? [['jwt' => []]] : null,
            'tags' => $tag ? [$tag] : null,
        ]);

        parent::__construct(...$modifiedArgs);
    }
}
