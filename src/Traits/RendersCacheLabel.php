<?php

declare(strict_types=1);

namespace TPG\Domains\Traits;

use function Termwind\render;
use function Termwind\span;

trait RendersCacheLabel
{
    public function renderCacheLabel(bool $cached): void
    {
        render([
            $cached
                ? span('This is CACHED data. Use --refresh to refresh', 'text-color-white bg-red p-2')
                : span('This is FRESH data', 'text-color-white bg-green p-2')
        ]);

    }
}
