<?php

declare(strict_types=1);

namespace TPG\Domains\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use TPG\Domains\Domains;

class ListCommand extends Command
{
    protected string $name = 'list';
    protected string $description = 'Get a list of domains';

    protected function configure(): void
    {
        parent::configure();

        $this->addArgument('filter', InputArgument::OPTIONAL, 'List filter');
    }

    protected function fire(): int
    {
        $domains = (new Domains($this->key))->list($this->argument('filter'));
        return 0;
    }
}
