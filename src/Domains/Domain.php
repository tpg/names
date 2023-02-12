<?php

namespace TPG\Names\Domains;

use Carbon\Carbon;

readonly class Domain
{
    public string $name;

    public ?string $contactName;

    public ?string $contactId;

    public ?string $status;

    public ?string $eppStatus;

    public bool $premiumDns;

    public Carbon $createdAt;

    public ?Carbon $expiresAt;

    public ?Carbon $suspendAt;

    public ?Carbon $redemptionDate;

    public ?Carbon $deleteDate;

    public bool $autoRenew;

    public ?string $externalReference;

    public ?array $nameservers;

    public function __construct(array $details)
    {
        $this->name = $details['strDomainName'];
        $this->contactName = $details['contactName'];
        $this->contactId = $details['strContactID'];
        $this->status = $details['status'];
        $this->eppStatus = $details['eppStatus'];
        $this->premiumDns = $details['strDns'] === 1;
        $this->createdAt = Carbon::createFromTimestamp($details['createdDate']);
        $this->expiresAt = Carbon::createFromTimestamp($details['expiryDate']);
        $this->suspendAt = Carbon::createFromTimestamp($details['suspendDate']);
        $this->redemptionDate = Carbon::createFromTimestamp($details['redemptionDate']);
        $this->deleteDate = Carbon::createFromTimestamp($details['deleteDate']);
        $this->autoRenew = $details['autorenew'] === 1;
        $this->externalReference = $details['externalRef'];
        $this->nameservers = $details['nameservers'];
    }

    public function isExpired(): bool
    {
        return $this->expiresAt->isPast() && $this->suspendAt->isFuture();
    }

    public function expiresThisMonth(): bool
    {
        return $this->expiresAt->isCurrentMonth();
    }

    public function expiresNextMonth(): bool
    {
        return $this->expiresAt->isNextMonth();
    }

    public function isSuspended(): bool
    {
        return $this->suspendAt->isPast() && $this->redemptionDate->isFuture();
    }

    public function inRedemption(): bool
    {
        return $this->redemptionDate->isPast();
    }
}
