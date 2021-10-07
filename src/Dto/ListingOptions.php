<?php

declare(strict_types=1);

namespace TPG\Domains\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class ListingOptions extends DataTransferObject
{
    public string $sortBy = 'name';
    public ?string $search = null;
    public ?string $filter = null;

    public function hash(): string
    {
        return md5(json_encode($this->all(), JSON_THROW_ON_ERROR));
    }
}
