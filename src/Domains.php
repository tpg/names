<?php

declare(strict_types=1);

namespace TPG\Domains;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class Domains
{
    public function __construct(protected string $key, protected bool $testing = false)
    {
    }

    public function check($sld, $tld): bool
    {
        $endpoint = $this->endpoint('domain/domain/check');

        $response = $this->request($endpoint, [
            'tld' => $tld,
            'sld' => $sld,
        ]);

        return Arr::get($response, 'isAvailable') === 'true';
    }

    public function info($sld, $tld): array
    {
        $endpoint = $this->endpoint('domain/domain/info');

        $response = $this->request($endpoint, [
            'tld' => $tld,
            'sld' => $sld,
        ]);

        return $response;
    }

    public function list(string $filter = null): array
    {
        $endpoint = $this->endpoint('domain/domain/domainList');

        $data = [];
        if ($filter) {
            $data['filter'] = $filter;
        }

        return $this->request($endpoint, $data);
    }

    protected function endpoint(string $uri): string
    {
        $domain = $this->testing
            ? 'api-dev3'
            : 'api-v3';

        return 'https://'.$domain.'.domains.co.za/api/'.$uri;
    }

    protected function request(string $endpoint, array $data = []): array
    {
        $client = new Client();

        $response = $client->post($endpoint, [
            'form_params' => array_merge([
                'key' => $this->key,
            ], $data)
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Bad response from domains.co.za');
        }

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }
}
