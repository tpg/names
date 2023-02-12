<?php

namespace TPG\Names;

use Http\Client\HttpClient;
use Illuminate\Support\Str;
use TPG\Names\Client\Method;
use TPG\Names\Client\RequestBuilder;
use TPG\Names\Domains\CheckResponse;
use TPG\Names\Domains\ListResponse;

class Domain
{
    protected RequestBuilder $requestBuilder;

    public function __construct(string $token, protected HttpClient $client)
    {
        $this->requestBuilder = new RequestBuilder($token);
    }

    public function check(string $domain): CheckResponse
    {
        $request = $this->requestBuilder->create(Method::Get, 'domain/check', [
            'tld' => Str::after($domain, '.'),
            'sld' => Str::before($domain, '.'),
        ]);

        $response = $this->client->sendRequest($request);

        return new CheckResponse($response);
    }

    public function list(string $tld = null): ListResponse
    {
        $request = $this->requestBuilder->create(Method::Get, 'domain/list', [
            ...$tld ? ['tld' => $tld] : [],
        ]);

        $response = $this->client->sendRequest($request);

        return new ListResponse($response);
    }
}
