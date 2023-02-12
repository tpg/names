# PHP client for the domains.co.za reseller API.

A full-featured PHP client for working with the domains.co.za reseller API. This is brand new and is a work in progress. It should not be used in production. It is likely to change significantly before reaching version 1.0.

You will need to have an active domains.co.za reseller account. You will need to provide your username and password to generate a new authentication token, or if you already have a token, you can provide that instead. Note that the library does not support 2 factor authentication.

## Installation
There are no versions just yet, so you will need to make sure your `composer.json` file has `"minimum-stability": "dev"` set.

The Names library is not bound to any HTTP client library and you can install any PSR-7, PST-17 and PSR-18 compatible library. A good start could be:

```shell
composer require thepublicgood/names guzzlehttp/guzzle php-http/guzzle7-adapter
```

## Usage
Create a new instance of the `Names` class and pass in your token if you have one. Otherwise, you can pass your username and password to the `authenticate` method:

```php
$names = new \TPG\Names\Names(token: $token);

// or

$names = new \TPG\Names\Names();
$auth = $names->authenticate($username, $password);

$token = $auth->token;
```

## Reseller Object
Many responses will included a `Reseller` object:

```php
$reseller = $response->reseller;

$reseller->username;        // string
$reseller->balance;         // float
$reseller->accountType;     // string
$reseller->lowBalance;      // bool
```

## Domains

### Checking if a domain is available

```php
$check = $names->domains()->check('is-this-available.com');

$check->requiresEpp;    // bool
$check->isAvailable;    // bool
$check->eppKey;         // string
$check->tld;            // string
$check->sld;            // string
$check->isPremium;      // bool
$check->reseller;       // Reseller object
```

### Getting a list of registered domains
```php
$list = $names->domains()->list();

// or

// Get a list of expired domains
$names->domains()->expired();

// Get a list of domains expiring next month
$names->domains()->expiringNextMonth();

// Get a list of suspended domains
$names->domains()->suspended();

// Get a list of domains currently in redemption
$names->domains()->redemption();
```

Each domain returned is a `Domain` object:

```php
$domain = $names->domains()->list()->first();

$domain->name;              // string
$domain->contactName;       // string
$domain->contactId;         // string
$domain->status;            // string
$domain->eppStatus;         // string
$domain->premiumDns;        // bool
$domain->createdAt;         // Carbon
$domain->expiresAt;         // Carbon
$domain->redemptionDate;    // Carbon
$domain->deletionDate;      // Carbon
$domain->autoRenew;         // bool
$domain->externalReference; // string
$domain->nameservers;       // array
```

## Credits
- [Warrick Bayman](https://github.com/warrickbayman)

## License
The MIT License (MIT). See the [LICENSE.md]() file for more details.
