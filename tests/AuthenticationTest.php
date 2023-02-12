<?php

test('it can authenticate', function () {
    $response = mockResponse([
        'intReturnCode' => \TPG\Names\ReturnCode::Success->value,
        'strUUID' => (string) \Illuminate\Support\Str::uuid(),
        'strMessage' => 'Authenticated',
        'token' => 'TEST-TOKEN',
        'strApiHost' => 'api.test.co.za',
    ]);

    $client = mockClient('/login', 'POST', $response);

    $names = new \TPG\Names\Names($client);

    $response = $names->authenticate('USERNAME', 'PASSWORD');

    $this->assertInstanceOf(\TPG\Names\Authenticated::class, $response);
    $this->assertSame('TEST-TOKEN', $response->token);
});

test('it can fail authentication', function () {
    $response = mockResponse([
        'intReturnCode' => \TPG\Names\ReturnCode::InvalidLoginCredentials,
        'strMessage' => 'Unauthorized',
        'strApiHost' => 'api.test.co.za',
    ]);

    $client = mockClient('/login', 'POST', $response);

    $names = new \TPG\Names\Names($client);

    $this->expectException(\TPG\Names\Exceptions\AuthenticationException::class);
    $response = $names->authenticate('USERNAME', 'PASSWORD');

    $this->assertSame(\TPG\Names\ReturnCode::InvalidLoginCredentials, $response->returnCode);
});
