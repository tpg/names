<?php

declare(strict_types=1);

namespace TPG\Domains\Commands;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Input\InputOption;
use TPG\Domains\Dto\Domain;
use TPG\Domains\Domains;
use TPG\Domains\Dto\ListingOptions;
use TPG\Domains\Dto\Response;
use TPG\Domains\Traits\RendersCacheLabel;
use TPG\Domains\Traits\RendersDomainsTable;
use function Termwind\render;
use function Termwind\span;

class DomainsListCommand extends Command
{
    use RendersDomainsTable, RendersCacheLabel;

    protected string $name = 'domains:list';
    protected string $description = 'Get a list of domains';

    protected function configure(): void
    {
        parent::configure();

        $this->addOption('search', 's', InputOption::VALUE_REQUIRED, 'Domain name search');
        $this->addOption('expiry', 'x', InputOption::VALUE_NONE, 'Sort by expiry date');
        $this->addOption('refresh', 'f', InputOption::VALUE_NONE, 'Refresh the stored cache');
    }

    protected function fire(): int
    {
        $options = new ListingOptions(
            sortBy: $this->option('expiry') ? 'dateExpiring' : 'name',
            search: $this->option('search'),
        );

        $domains = (new Domains($this->configuration->key(), $this->configuration->testing()))->list($options, $this->option('refresh'));

        $this->renderDomainsTable($domains);
        $this->renderCacheLabel($domains->cached);

        return 0;
    }

}
