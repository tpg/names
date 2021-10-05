<?php

declare(strict_types=1);

namespace TPG\Domains\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use TPG\Domains\Domains;

class InformationCommand extends Command
{
    protected string $name = 'info';
    protected string $description = 'Get domain information';

    protected function configure(): void
    {
        parent::configure();

        $this->addArgument('domain', InputArgument::REQUIRED, 'The domain to get information for');
    }

    protected function fire(): int
    {
        $sld = Str::before($this->argument('domain'), '.');
        $tld = Str::after($this->argument('domain'), '.');

        $info = (new Domains($this->key))->info($sld, $tld);

        ray($info);

        return 0;
    }
}
