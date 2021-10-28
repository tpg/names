<?php

declare(strict_types=1);

namespace TPG\Domains;

use Symfony\Component\Console\Application as ConsoleApplication;
use TPG\Domains\Commands\CheckCommand;
use TPG\Domains\Commands\ClearCacheCommand;
use TPG\Domains\Commands\DomainsExpiringCommand;
use TPG\Domains\Commands\InstallCommand;
use TPG\Domains\Commands\DomainsListCommand;

class Application
{
    protected string $name = 'Domains';
    protected string $version = '0.1.0';

    protected Configuration $configuration;
    protected ConsoleApplication $consoleApplication;

    protected array $commands = [
        CheckCommand::class,
        ClearCacheCommand::class,
        DomainsListCommand::class,
        DomainsExpiringCommand::class,
    ];


    public function __construct()
    {
        $this->configuration = new Configuration();

        $this->consoleApplication = new ConsoleApplication($this->name, $this->version);
    }

    public function boot(): ConsoleApplication
    {
        foreach ($this->commands as $command) {
            $this->consoleApplication->add(new $command($this->configuration));
        }

        if (! $this->configuration->isConfigured()) {
            $this->consoleApplication->add(new InstallCommand($this->configuration));
        }

        return $this->consoleApplication;
    }
}
