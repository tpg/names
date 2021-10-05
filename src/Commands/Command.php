<?php

declare(strict_types=1);

namespace TPG\Domains\Commands;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TPG\Domains\Configuration;

abstract class Command extends SymfonyCommand
{
    protected InputInterface $input;
    protected OutputInterface $output;

    protected string $name;
    protected string $description;

    protected string $key;

    public function __construct()
    {
        parent::__construct();

        $this->key = (new Configuration())->key();
    }

    protected function configure(): void
    {
        $this->setName($this->name)
            ->setDescription($this->description);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        set_time_limit(0);

        $this->input = $input;
        $this->output = $output;

        return (int) $this->fire();
    }

    protected function option(string $key): mixed
    {
        return $this->input->getOption($key);
    }

    public function argument(string $key): mixed
    {
        return $this->input->getArgument($key);
    }

    abstract protected function fire(): int;
}
