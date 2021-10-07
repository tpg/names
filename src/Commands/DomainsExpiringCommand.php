<?php

declare(strict_types=1);

namespace TPG\Domains\Commands;

use Symfony\Component\Console\Input\InputOption;
use TPG\Domains\Domains;
use TPG\Domains\Dto\ListingOptions;
use TPG\Domains\Traits\RendersCacheLabel;
use TPG\Domains\Traits\RendersDomainsTable;

class DomainsExpiringCommand extends Command
{
    use RendersDomainsTable, RendersCacheLabel;

    protected string $name = 'domains:expiring';
    protected string $description = 'List of expiring domains (within 60 days)';

    protected function configure(): void
    {
        parent::configure();

        $this->addOption('search', 's', InputOption::VALUE_REQUIRED, 'Domain name search');
        $this->addOption('refresh', 'f', InputOption::VALUE_NONE, 'Refresh the stored cache');
    }

    protected function fire(): int
    {
        $options = new ListingOptions(
            search: $this->option('search'),
            filter: 'expiring60',
        );

        $domains = (new Domains($this->configuration->key(), $this->configuration->testing()))->list($options, $this->option('refresh'));

        $this->renderDomainsTable($domains);
        $this->renderCacheLabel($domains->cached);

        return 0;
    }
}
