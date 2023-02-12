<?php

namespace TPG\Names;

use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface;

readonly class Response
{
    protected array $body;

    public ReturnCode $returnCode;

    public ?string $uuid;

    public ?string $message;

    public ?string $reason;

    public ?string $host;

    public ?Reseller $reseller;

    public function __construct(ResponseInterface $response)
    {
        $this->body = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        $this->returnCode = ReturnCode::from($this->json('intReturnCode'));
        $this->uuid = $this->json('strUUID');
        $this->message = $this->json('strMessage');
        $this->reason = $this->json('strReason');
        $this->host = $this->json('strApiHost');
//        $this->reseller = new Reseller(...$this->json('objReseller'));
    }

    public function json(string $key): mixed
    {
        return Arr::get($this->body, $key);
    }
}
