<?php

namespace TPG\Names\Domains;

use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;
use TPG\Names\Response;

readonly class ListResponse extends Response
{
    public int $total;

    public int $filterTotal;

    public int $returnedTotal;

    /**
     * @var Collection<Domain>
     */
    public Collection $domains;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);

        $this->total = $this->body['intTotal'];
        $this->filterTotal = $this->body['intFilterTotal'];
        $this->returnedTotal = $this->body['intReturnedTotal'];
        $this->domains = (new Collection($this->json('arrDomains')))->map(fn ($data) => new Domain($data));
    }

    public function expired(): Collection
    {
        return $this->domains->filter(fn (Domain $domain) => $domain->isExpired() && ! $domain->isSuspended());
    }

    public function suspended(): Collection
    {
        return $this->domains->filter(fn (Domain $domain) => $domain->isSuspended() && ! $domain->inRedemption());
    }

    public function redemption(): Collection
    {
        return $this->domains->filter(fn (Domain $domain) => $domain->inRedemption());
    }

    public function expiringNextMonth(): Collection
    {
        return $this->domains->filter(fn (Domain $domain) => $domain->expiresNextMonth());
    }
}
