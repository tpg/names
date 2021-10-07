<?php

declare(strict_types=1);

namespace TPG\Domains\Dto;

use Carbon\Carbon;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;
use TPG\Domains\Casters\CarbonCaster;

class Domain extends DataTransferObject
{
    #[MapFrom('strDomainName')]
    public string $name;

    public string $contactName;

    #[MapFrom('strContactID')]
    public string $contactId;

    #[CastWith(CarbonCaster::class)]
    public Carbon $createdDate;

    #[CastWith(CarbonCaster::class)]
    public Carbon $expiryDate;

    #[MapFrom('autorenew')]
    public bool $autoRenew;

    public array $nameservers;

    public function expired(): bool
    {
        return $this->expiryDate->lt(Carbon::now());
    }

    public function expiresThisMonth(): bool
    {
        return $this->expiryDate->isCurrentMonth();
    }

    public function expiresNextMonth(): bool
    {
        return $this->expiryDate->isNextMonth();
    }
}
