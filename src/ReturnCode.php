<?php

declare(strict_types=1);

namespace TPG\Domains;

class ReturnCode
{
    public const NOT_AVAILABLE = 0;
    public const SUCCESSFUL = 1;
    public const PENDING_SUCCESSFUL = 2;
    public const ITEM_NOT_PENDING = 4;
    public const INVALID_KEY = 6;
    public const AUTHENTICATION_ERROR = 7;
    public const ASSOCIATION_PROHIBITED = 8;
    public const UNKNOWN_ERROR = 9;
    public const MISSING_PARAMETER = 10;
    public const DOES_NOT_EXIST = 11;
    public const STATUS_PROHIBITS = 12;
    public const ALREADY_EXISTS = 13;
    public const SYNTAX_ERROR = 14;
    public const UNKNOWN_COMMAND = 15;
    public const DATABASE_FAILED = 16;
    public const INTERNAL_ERROR = 17;
    public const CONNECTION_REFUSED = 18;
    public const BILLING_FAILURE = 19;
    public const TIMED_OUT = 20;
    public const CONNECTION_FAILED = 22;

    public function message(int $code): string
    {
        return match ($code) {
            self::NOT_AVAILABLE => 'Not Available or Failed',
            self::SUCCESSFUL => 'Successful',
            self::PENDING_SUCCESSFUL => 'Pending Action Successful',
            self::ITEM_NOT_PENDING => ' Item Not Pending Action',
            self::INVALID_KEY => 'Invalid API Key/Invalid Username OR Password',
            self::AUTHENTICATION_ERROR => 'Authentication Error',
            self::ASSOCIATION_PROHIBITED => 'Association Prohibits Operation',
            self::UNKNOWN_ERROR => 'Unknown Error',
            self::MISSING_PARAMETER => 'Missing Parameter',
            self::DOES_NOT_EXIST => 'Item Does Not Exist',
            self::STATUS_PROHIBITS => 'Status Prohibits Operation',
            self::ALREADY_EXISTS => 'Item already exists',
            self::SYNTAX_ERROR => 'Command Syntax Error',
            self::UNKNOWN_COMMAND => 'Unknown Command',
            self::DATABASE_FAILED => 'Database Call Failed',
            self::INTERNAL_ERROR => 'Internal Error',
            self::CONNECTION_REFUSED => 'Connection Refused',
            self::BILLING_FAILURE => 'Billing Failure',
            self::TIMED_OUT => 'Request Timed Out',
            self::CONNECTION_FAILED => 'Connection Failed to Provider',
        };
    }
}
