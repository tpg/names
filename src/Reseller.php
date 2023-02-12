<?php

namespace TPG\Names;

readonly class Reseller
{
    public function __construct(
        public string $username,
        public string $balance,
        public string $accountType,
        public bool $lowBalance
    ) {
    }
}
