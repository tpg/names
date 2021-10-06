<?php

declare(strict_types=1);

namespace TPG\Domains;

use Carbon\Carbon;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;
use TPG\Domains\Casters\CarbonCaster;

class Info extends DataTransferObject
{
    #[MapFrom('intReturnCode')]
    public int $returnCode;

    #[MapFrom('strUUID')]
    public string $uuid;

    #[MapFrom('strDomainName')]
    public string $name;

    #[MapFrom('strStatus')]
    public string $status;

    #[MapFrom('strEppStatus')]
    public string $eppStatus;

    #[MapFrom('strDns')]
    public bool $premiumDns;

    #[MapFrom('arrNameservers')]
    public array $nameservers;

    #[MapFrom('autorenew')]
    public bool $autoRenew;

    #[MapFrom('intCrDate')]
    #[CastWith(CarbonCaster::class)]
    public Carbon $creationDate;

    #[MapFrom('intExDate')]
    #[CastWith(CarbonCaster::class)]
    public Carbon $expiryDate;

    #[MapFrom('intSuspendDate')]
    #[CastWith(CarbonCaster::class)]
    public Carbon $suspendDate;

    #[MapFrom('intRedemptionDate')]
    #[CastWith(CarbonCaster::class)]
    public Carbon $redemptionDate;

    #[MapFrom('intDeleteDate')]
    #[CastWith(CarbonCaster::class)]
    public Carbon $deleteDate;

    #[MapFrom('intLastRenewedDate')]
    #[CastWith(CarbonCaster::class)]
    public Carbon $lastRenewedDate;

    #[MapFrom('intUpDate')]
    #[CastWith(CarbonCaster::class)]
    public Carbon $updateDate;

    #[MapFrom('intNSUpDate')]
    #[CastWith(CarbonCaster::class)]
    public Carbon $nsUpdateDate;

    public static function acceptable(): array
    {
        return [
            'intReturnCode',
            'strUUID',
            'strDomainName',
            'strStatus',
            'strEppStatus',
            'strDns',
            'arrNameservers',
            'autorenew',
            'intCrDate',
            'intExDate',
            'intSuspendDate',
            'intRedemptionDate',
            'intDeleteDate',
            'intLastRenewedDate',
            'intUpDate',
            'intNSUpDate'
        ];
    }

}
