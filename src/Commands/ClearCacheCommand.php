<?php

declare(strict_types=1);

namespace TPG\Domains\Commands;

use TPG\Domains\Cache;

class ClearCacheCommand extends Command
{
    protected string $name = 'cache:clear';
    protected string $description = 'Clear any cached responses';

    protected function fire(): int
    {
        (new Cache())->clear();
        $this->output->writeln('<fg=green>Cache cleared</>');

        return 0;
    }
}
