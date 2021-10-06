<?php

declare(strict_types=1);

namespace TPG\Domains;

use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class Response extends DataTransferObject
{
    public ?int $returnCode = null;
    public bool $cached = false;
    public mixed $data;

    public function returnMessage(): ?string
    {
        if (! $this->returnCode) {
            return null;
        }

        return (new ReturnCode())->message($this->returnCode);
    }
}
