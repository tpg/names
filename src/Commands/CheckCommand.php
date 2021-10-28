<?php

declare(strict_types=1);

namespace TPG\Domains\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use TPG\Domains\Domains;

class CheckCommand extends Command
{
    protected string $name = 'domains:check';
    protected string $description = 'Check if a domain is registered';

    protected function configure(): void
    {
        parent::configure();

        $this->addArgument('domain', InputArgument::REQUIRED, 'The domain to check');
    }

    protected function fire(): int
    {
        $sld = Str::before($this->argument('domain'), '.');
        $tld = Str::after($this->argument('domain'), '.');

        $this->output->writeln('Searching '.$sld.' in TLD '.$tld.'... ');

        $check = (new Domains($this->configuration->key(), $this->configuration->testing()))->check($sld, $tld);

        if ($check) {
            $this->output->writeln('<fg=green>Available</>');
            return 0;
        }

        $this->output->writeln('<fg=red>Unavailable</>');
        return 0;
    }
}
