<?php

declare(strict_types=1);

namespace TPG\Domains\Commands;

use Symfony\Component\Console\Input\InputArgument;
use TPG\Domains\Configuration;

class InstallCommand extends Command
{
    protected string $name = 'install';
    protected string $description = 'Install the domains CLI tool';

    protected function configure(): void
    {
        parent::configure();

        $this->addArgument('key', InputArgument::REQUIRED, 'domains.co.za reseller API key');
    }

    protected function fire(): int
    {

        $config = [
            'reseller' => [
                'key' => $this->argument('key'),
            ]
        ];

        (new Configuration())->createConfiguration($config);

        return 0;
    }
}
