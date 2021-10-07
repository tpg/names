<?php

declare(strict_types=1);

namespace TPG\Domains\Traits;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use TPG\Domains\Dto\Domain;
use TPG\Domains\Dto\Response;

trait RendersDomainsTable
{
    protected function renderDomainsTable(Response $domains): void
    {
        $table = new Table($this->output);
        $table->setHeaders([
            'Name',
            'Expires',
            'Auto Renew',
            'Contact',
        ])->setRows(
            $domains->data->map(fn (Domain $domain) => [
                $domain->name,
                new TableCell(
                    $domain->expiryDate->format('d F Y'),
                    [
                        'style' => new TableCellStyle([
                            'bg' => $this->expiryColour($domain),
                        ]),
                    ]
                ),
                $domain->autoRenew ? 'Y' : '',
                $domain->contactName
            ])->toArray()
        );

        $table->setStyle('box')->render();
    }

    protected function expiryColour(Domain $domain): string
    {
        if ($domain->expired()) {
            return 'red';
        }
        if ($domain->expiresThisMonth()) {
            return 'red';
        }
        if ($domain->expiresNextMonth()) {
            return 'blue';
        }

        return 'green';
    }
}
