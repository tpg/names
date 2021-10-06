<?php

declare(strict_types=1);

namespace TPG\Domains\Commands;

use TPG\Domains\Cache;
use function Termwind\span;

class ClearCacheCommand extends Command
{
    protected string $name = 'cache:clear';
    protected string $description = 'Clear any cached responses';

    protected function fire(): int
    {
        (new Cache())->clear();
        span('Cache cleared', 'text-color-green')->render();

        return 0;
    }
}
