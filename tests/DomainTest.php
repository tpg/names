<?php

//test('it will throw an exception without a token', function () {
//
//    $response = mockResponse([
//        'intReturnCode' => \TPG\Names\ReturnCode::InvalidLoginCredentials->value,
//        'strUUID' => \Illuminate\Support\Str::uuid()->toString(),
//        'strMessage' => 'Unauthorized',
//        'strApiHost' => 'api.test.co.za',
//    ]);
//
//    $client = mockClient('/domain/check', 'GET', $response);
//
//    $names = new \TPG\Names\Names($client, 'BAD-TOKEN');
//
////    $this->expectException(\TPG\Names\Exceptions\AuthenticationException::class);
//    $response = $names->domains()->check('unregistered-domain-that-doesnt-exist.co.za');
//
//});

test('it can check if a domain is available', function () {
    $response = mockResponse([
        'intReturnCode' => \TPG\Names\ReturnCode::Success->value,
        'strUUID' => \Illuminate\Support\Str::uuid()->toString(),
        'strMessage' => 'Domain Available',
        'usesEppKey' => false,
        'isAvailable' => true,
        'strReason' => '',
        'tld' => 'co.za',
        'sld' => 'unregistered-domain-that-doesnt-exist',
        'isPremium' => false,
        'objReseller' => [
            'username' => 'test-username',
            'balance' => '0.00',
            'accountType' => 'Reseller',
            'lowBalance' => false,
        ],
        'strApiHost' => 'api-node-01',
    ]);

    $client = mockClient('/domain/check', 'GET', $response);

    $names = new \TPG\Names\Names($client, 'TEST-TOKEN');

    $response = $names->domains()->check('unregistered-domain-that-doesnt-exist.co.za');

    $this->assertTrue($response->isAvailable);

    return $response;
});

test('it will return a reseller object', function (TPG\Names\Domains\CheckResponse $response) {
    $this->assertSame('test-username', $response->reseller->username);
})->depends('it can check if a domain is available');
