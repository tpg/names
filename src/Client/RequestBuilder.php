<?php

namespace TPG\Names\Client;

use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class RequestBuilder
{
    private RequestFactoryInterface $requestFactory;

    private StreamFactoryInterface $streamFactory;

    private string $url = 'https://api.domains.co.za/api';

    public function __construct(private ?string $token = null)
    {
        $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
    }

    public function create(Method $method, string $uri, array $body = []): RequestInterface
    {
        $request = $this->requestFactory->createRequest($method->value, $this->url.'/'.$uri);
        $json = json_encode($body, JSON_THROW_ON_ERROR);
        $stream = $this->streamFactory->createStream($json);
        $stream->rewind();

        $request = $request->withBody($stream);
        $request = $request->withAddedHeader('Content-Type', 'application/json');

        if ($this->token) {
            $request = $request->withAddedHeader('Authorization', 'Bearer '.$this->token);
        }

        return $request;
    }
}
