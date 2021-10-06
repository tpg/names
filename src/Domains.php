<?php

declare(strict_types=1);

namespace TPG\Domains;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

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

    public function info($sld, $tld): Info
    {
        $endpoint = $this->endpoint('domain/domain/info');

        $response = $this->request($endpoint, [
            'tld' => $tld,
            'sld' => $sld,
        ]);

        return new Info(Arr::only($response, Info::acceptable()));
    }

    public function list(ListingOptions $options = null, bool $refresh = false): Response
    {
        $options = $options ?? new ListingOptions();

        $endpoint = $this->endpoint('domain/domain/domainList');

        $cache = new Cache();

        if ($refresh) {
            $cache->forget('list-'.$options->hash());
        }

        $response = new Response(cached: true);

        $domains = (new Cache())->remember(
            'list-'.$options->hash(),
            Carbon::now()->addHour(),
            function () use ($endpoint, $options, $response) {

                $response->cached = false;

                return $this->request($endpoint, $options->toArray());

            });

        $response->returnCode = $domains['intReturnCode'];

        $response->data = collect($domains['arrDomains'])->map(fn ($domain) => new Domain(
            Arr::only($domain, [
                'strDomainName',
                'contactName',
                'strContactID',
                'createdDate',
                'expiryDate',
                'autorenew',
                'nameservers',
            ])
        ));

        return $response;
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
