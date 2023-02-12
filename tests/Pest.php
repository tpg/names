<?php

use Http\Mock\Client as MockClient;
use Psr\Http\Message\ResponseInterface;

function mockClient($endpoint, string $method, ResponseInterface $response): MockClient
{
    $client = new MockClient();
    $requestMatcher = new \Http\Message\RequestMatcher\RequestMatcher('/api'.$endpoint, 'api.domains.co.za', $method);

    $client->on($requestMatcher, $response);

    return $client;
}

function mockResponse(array $data): ResponseInterface
{
    $stream = Mockery::mock(\Psr\Http\Message\StreamInterface::class);

    $stream->shouldReceive('getContents')->andReturn(
        json_encode($data)
    );

    $response = Mockery::mock(ResponseInterface::class);
    $response->shouldReceive('getBody')->andReturn($stream);

    return $response;
}
