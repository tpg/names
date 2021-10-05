<?php

declare(strict_types=1);

namespace TPG\Domains\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use TPG\Domains\Configuration;
use TPG\Domains\Domains;
use function Termwind\render;
use function Termwind\span;

class CheckCommand extends Command
{
    protected string $name = 'check';
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

        span('Searching '.$sld.' in TLD '.$tld, 'p-1 text-color-blue')->render();

        $check = (new Domains($this->key))->check($sld, $tld);

        if ($check) {
            span('Available', 'text-color-green')->render();
            return 0;
        }

        span('Unavailable', 'text-color-red')->render();
        return 0;
    }
}
