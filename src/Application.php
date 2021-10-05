<?php

declare(strict_types=1);

namespace TPG\Domains;

use Symfony\Component\Console\Application as ConsoleApplication;
use TPG\Domains\Commands\CheckCommand;
use TPG\Domains\Commands\InformationCommand;
use TPG\Domains\Commands\InstallCommand;
use TPG\Domains\Commands\ListCommand;

class Application
{
    protected string $name = 'Domains';
    protected string $version = '0.0.1';

    protected ConsoleApplication $consoleApplication;

    protected array $commands = [
        CheckCommand::class,
        InformationCommand::class,
        InstallCommand::class,
        ListCommand::class,
    ];

    public function __construct()
    {
        $this->consoleApplication = new ConsoleApplication($this->name, $this->version);
    }

    public function boot(): ConsoleApplication
    {
        foreach ($this->commands as $command) {
            $this->consoleApplication->add(new $command());
        }

        return $this->consoleApplication;
    }
}
