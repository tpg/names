<?php

namespace TPG\Names;

use Psr\Http\Message\ResponseInterface;

readonly class Authenticated extends Response
{
    public ?string $token;

    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);

        $this->token = $this->json('token');
    }
}
