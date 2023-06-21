# Investec API SDK for PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nikspyratos/investec-sdk-php.svg?style=flat-square)](https://packagist.org/packages/nikspyratos/investec-sdk-php)
[![Tests](https://img.shields.io/github/actions/workflow/status/nikspyratos/investec-sdk-php/run-tests-pest.yml?branch=main&label=tests&style=flat-square)](https://github.com/nikspyratos/investec-sdk-php/actions/workflows/run-tests-pest.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/nikspyratos/investec-sdk-php.svg?style=flat-square)](https://packagist.org/packages/nikspyratos/investec-sdk-php)
---

<!-- TOC -->
* [Investec API SDK for PHP](#investec-api-sdk-for-php)
  * [Support](#support)
  * [Installation](#installation)
  * [Usage](#usage)
    * [Personal use](#personal-use)
    * [Business use](#business-use)
    * [Environments](#environments)
    * [Data Transfer Objects](#data-transfer-objects)
  * [Testing](#testing)
  * [Roadmap for v0.1.0](#roadmap-for-v010)
    * [Beyond](#beyond)
  * [Changelog](#changelog)
  * [Contributing](#contributing)
  * [Security Vulnerabilities](#security-vulnerabilities)
  * [Credits](#credits)
  * [License](#license)
<!-- TOC -->

This is a PHP SDK for [Investec's API](https://developer.investec.com/za/api-products/), using [Saloon](https://github.com/Sammyjo20/Saloon).

This is a community-made package, and not directly affiliated with Investec.

## Support

Buy me a coffee: https://tip-jar.co.za/@thecapegreek

## Installation

You can install the package via composer:

```bash
composer require nikspyratos/investec-sdk-php
```

## Usage

See the [package documentation](DOCUMENTATION.md) and [API documentation](https://developer.investec.com/za/api-products) for more details.

If you're accessing your own account data, see [Personal use](#personal-use). If you're accessing Investec customer data, see [Business use](#business-use).

See [Environments](#environments) for accessing the Sandbox environment.

### Personal use

Firstly, make sure you've [obtained your API credentials](https://offerzen.gitbook.io/programmable-banking-community-wiki/get-started/api-quick-start-guide#how-to-get-your-api-keys) - this is how you get your client ID, secret and API key.

Note: Personal use access tokens have a lifespan of 30 minutes.

```php
use InvestecSdkPhp\Connectors\InvestecConnector;

$clientId = '';
$clientSecret = '';
$apiKey = '';

//Initialise the API Connector
$connector = new InvestecConnector($clientId, $clientSecret, $apiKey);

//Get an access token
$authenticator = $connector->getAccessToken();

//Use it to authenticate requests for Private Banking
$api = $connector->privateBanking($authenticator);

//Have fun!
$data = $api->getAccounts();
```

### Business use

See [API documentation](https://developer.investec.com/za/api-products) for details.

Your organisation will need to chat with Investec directly to get access. The Investec API uses an OAuth flow for the customer to grant access to you for their data.

Reminder: This package is not affiliated with Investec.

```php
use InvestecSdkPhp\Connectors\InvestecOAuthConnector;

$clientId = '';
$clientSecret = '';
$redirectUri = '';

//Initialise the API Connector
$connector = new InvestecOAuthConnector($clientId, $clientSecret);

//Create an OAuth authorization URL. You redirect your user to this
$authUrl = $connector->getAuthorizationUrl($redirectUri);
```
After being redirected back to your specified `$redirectUri`, you should have a code. Proceed as usual:
```php
//Authorization code from the redirect
$code = ''

//Initialise the API Connector
$connector = new InvestecOAuthConnector($clientId, $clientSecret);

//Get an access token - this will still require the redirect URI
$authenticator = $connector->getAccessToken($redirectUri, $code);

//Use it to authenticate requests for Private Banking
$api = $connector->privateBanking($authenticator);

//Have fun!
$data = $api->getAccounts();
```

### Environments

The API offers two environments: Sandbox and Production.

By default this SDK will use the Production environment. To change this, you may specify the environment using the provided enum like so:

```php
use InvestecSdkPhp\Enumerations\Environment;
$connector = new InvestecConnector($clientId, $clientSecret, Environment::SANDBOX);
```

### Data Transfer Objects

For `Transfer Multiple` and `Pay Multiple` endpoints, arrays of beneficiaries/accounts are accepted.

To handle this in a structured manner this package uses `dragon-code/simple-dto` to build the DTOs with the required data.

## Testing

```bash
vendor/bin/pest
```

## Roadmap for v0.1.0

- Private banking API transfers
- Stabilise the 3-Legged OAuth flow
- Linting

### Beyond

I intend to implement the other endpoint groups (Corporate Banking, Card Code, Forex) as minor releases.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Nik Spyratos](https://github.com/nikspyratos)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
