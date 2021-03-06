<?php

declare(strict_types=1);

namespace TPG\Domains\Casters;

use Carbon\Carbon;
use Spatie\DataTransferObject\Caster;

class CarbonCaster implements Caster
{
    public function cast(mixed $value): Carbon
    {
        return Carbon::createFromTimestamp($value);
    }
}
