<?php

declare(strict_types=1);

namespace TPG\Domains\Traits;

trait RendersCacheLabel
{
    public function renderCacheLabel(bool $cached): void
    {
        $cached
            ? $this->output->writeln('<bg=red;fg=white> This is CACHED data. Use --refresh to refresh </>')
            : $this->output->writeln('<bg=green;fg=white> This is FRESH data </>');
    }
}
