<?php

namespace TPG\Names\Exceptions;

use TPG\Names\ReturnCode;

class AuthenticationException extends \Exception
{
    public static function fromReturnCode(ReturnCode $returnCode, string $message = null): static
    {
        $message ??= match ($returnCode) {
            ReturnCode::InvalidLoginCredentials => 'The login credentials are invalid',
            default => 'Unknown authentication error',
        };

        return new static($message, $returnCode->value);
    }
}
