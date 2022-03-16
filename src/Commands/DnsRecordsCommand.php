<?php

declare(strict_types=1);


namespace TPG\Domains\Commands;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use League\Csv\Writer;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use TPG\Domains\Domains;

class DnsRecordsCommand extends Command
{
    protected string $name = 'dns:records';

    protected string $description = 'Get DNS records for the specified domain';

    protected function configure(): void
    {
        parent::configure();

        $this->addArgument('domain', InputArgument::REQUIRED, 'The domain name');
        $this->addOption('output', 'o', InputOption::VALUE_REQUIRED, 'Optional output CSV file');
    }

    protected function fire(): int
    {
        $sld = Str::before($this->argument('domain'), '.');
        $tld = Str::after($this->argument('domain'), '.');

        $records = (new Domains($this->configuration->key(), $this->configuration->testing()))->dns($sld, $tld);

        $this->recordsTable($records);

        if ($this->option('output')) {
            $this->writeCsv($this->option('output'), $records);
        }
        return 0;
    }

    protected function recordsTable(Collection $records): void
    {
        $table = new Table($this->output);
        $table->setHeaders($this->getTableHeaders())
            ->setRows(
                $records->toArray(),
            );

        $table->setStyle('box')->render();
    }

    protected function writeCsv(string $filename, Collection $records): void
    {
        $csv = Writer::createFromString();

        $csv->insertOne($this->getTableHeaders());
        $csv->insertAll(($records->toArray()));

        file_put_contents($filename, $csv->toString());
    }

    protected function getTableHeaders(): array
    {
        return ['Type', 'Name', 'Content', 'TTL', 'Priority'];
    }
}
