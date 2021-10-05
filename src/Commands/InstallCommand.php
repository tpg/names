<?php

declare(strict_types=1);

namespace TPG\Domains\Commands;

class InstallCommand extends Command
{
    protected string $name = 'install';
    protected string $description = 'Install the domains CLI tool';

    protected function fire(): int
    {
        return 0;
    }
}
