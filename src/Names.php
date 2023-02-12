<?php

namespace TPG\Names;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Psr\Http\Client\ClientInterface;
use TPG\Names\Client\Method;
use TPG\Names\Client\RequestBuilder;
use TPG\Names\Exceptions\AuthenticationException;

class Names
{
    protected HttpClient $client;

    protected RequestBuilder $requestBuilder;

    protected ?string $token;

    public function __construct(?ClientInterface $client = null, ?string $token = null)
    {
        $this->client = $client ?? $this->configureClient();
        $this->requestBuilder = new RequestBuilder();
        $this->token = $token;
    }

    public function authenticate(string $username, string $password): Authenticated
    {
        $request = $this->requestBuilder->create(Method::Post, 'login', [
            'username' => $username,
            'password' => $password,
        ]);

        $response = $this->client->sendRequest($request);

        $auth = new Authenticated($response);

        $this->token = $auth->token;

        return $this->authenticationResponse($auth);
    }

    protected function authenticationResponse(Authenticated $authenticated): Authenticated
    {
        if ($authenticated->returnCode !== ReturnCode::Success) {
            throw AuthenticationException::fromReturnCode($authenticated->returnCode);
        }

        return $authenticated;
    }

    public function configureClient(): HttpClient
    {
        return HttpClientDiscovery::find();
    }

    public function domains(): Domain
    {
        return new Domain($this->token, $this->client);
    }
}
