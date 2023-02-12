<?php

namespace TPG\Names\Domains;

use Psr\Http\Message\ResponseInterface;
use TPG\Names\Exceptions\AuthenticationException;
use TPG\Names\Reseller;
use TPG\Names\Response;
use TPG\Names\ReturnCode;

readonly class CheckResponse extends Response
{
    public ?bool $requiresEpp;

    public ?bool $isAvailable;

    public ?string $tld;

    public ?string $sld;

    public ?bool $isPremium;

    public ?Reseller $reseller;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);

        if ($this->returnCode !== ReturnCode::Success) {
            $this->throwOnError();
        }

        $this->requiresEpp = $this->json('usesEppKey');
        $this->isAvailable = $this->json('isAvailable');
        $this->tld = $this->json('tld');
        $this->sld = $this->json('sld');
        $this->isPremium = $this->json('isPremium');
        $this->reseller = new Reseller(...$this->json('objReseller'));
    }

    protected function throwOnError(): bool
    {
        match ($this->returnCode) {
            ReturnCode::InvalidLoginCredentials => throw AuthenticationException::fromReturnCode($this->returnCode),
            default => throw new \RuntimeException($this->message, $this->returnCode->value),
        };
    }
}
