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
    * [Internal use](#internal-use)
    * [External use](#external-use)
    * [Environments](#environments)
    * [Data Transfer Objects](#data-transfer-objects)
  * [Testing](#testing)
  * [Roadmap](#roadmap)
  * [Changelog](#changelog)
  * [Contributing](#contributing)
  * [Security Vulnerabilities](#security-vulnerabilities)
  * [Credits](#credits)
  * [License](#license)
<!-- TOC -->

This is a PHP SDK for [Investec's API](https://developer.investec.com/za/api-products/), using [Saloon](https://github.com/Sammyjo20/Saloon).

This is a community-made package, and not directly affiliated with Investec.

## Support

- [Buy me a coffee](https://tip-jar.co.za/@thecapegreek)
- I also [consult in the Laravel & payments space](https://nik.software)

## Installation

You can install the package via composer:

```bash
composer require nikspyratos/investec-sdk-php
```

**NOTE**: Currently, the stable release only includes support for authorization (both personal and 3-legged OAuth) and the Private Banking API. Other APIs are written but untested. See [Roadmap](#roadmap) for more details.

If you would like to use these other APIs, install from the `main` branch:

```bash
composer require nikspyratos/investec-sdk-php:"dev-main"
```

## Usage

See the [package documentation](DOCUMENTATION.md) and [API documentation](https://developer.investec.com/za/api-products) for more details.

If you're accessing your own account data, see [Internal use](#internal-use). If you're accessing Investec customer data, see [External use](#external-use).

See [Environments](#environments) for accessing the Sandbox environment.

### Internal use

Firstly, make sure you've [obtained your API credentials](https://offerzen.gitbook.io/programmable-banking-community-wiki/get-started/api-quick-start-guide#how-to-get-your-api-keys) - this is how you get your client ID, secret and API key.

Note: `Internal use` access tokens have a lifespan of 30 minutes.

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

### External use

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

Tests are set to run with sandbox credentials (which Investec provides us with, luckily).

```bash
cp .env.example .env
```

Then, copy the sandbox environment variable values from [here](https://developer.investec.com/za/api-products/documentation/SA_PB_Account_Information#section/Sandbox) into your .env file.

Then, to run tests:

```bash
vendor/bin/pest
```

## TODO

1. Using the excellent [Saloon SDK Generator](https://github.com/crescat-io/saloon-sdk-generator), the remaining APIs have been implemented, save for some Forex API endpoints:
- `Update BOP Report` - the input is massive and has several nested arrays and objects, resulting in a DTO nightmare currently.
- `Validate BOP Report` - similar issues to `Update BOP Report`.
- `Upload file contents for document handle` - documentation is unclear on how to fill in this data.

2. For the implemented endpoints, tests are either not working (sandbox credentials issue) or are unwritten. Given that, I'm not comfortable releasing a new stable version for these APIs.
If you'd like to use these, change your package requirement to `dev-main`.
At this time, there also hasn't been much demand for these APIs in this SDK, so it's preferrable to not do more work for code that won't be used.
If you would like to see any of those APIs reach a stable release, please contribute by:
- Letting us know if it works, any issues you run into, etc.
- Make a PR with working tests for an API matching the existing testing style, using PestPHP
- Make a PR updating the [Documentation](DOCUMENTATION.md) with usage guides for the remaining endpoints

TODOs:
- Re-evaluate how token handling and scopes are done in this package - Especially with Saloon's updates since launch ([1](https://twitter.com/carre_sam/status/1674423476579627008)), some of it may now be redundant.
- [Upgrade to Saloon v3](https://docs.saloon.dev/upgrade/whats-new-in-v3)
- Re-evaluate existing implemented endpoints - may be changes due to API request/response additions/changes
- Implement remaining endpoints described above
- Get existing tests working again either with sandbox credentials or with mocking
- Tests for remaining API endpoint groups

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Nik Spyratos](https://github.com/nikspyratos)
- [All Contributors](../../contributors)
- [Saloon](https://docs.saloon.dev)
- [Saloon SDK Generator](https://github.com/crescat-io/saloon-sdk-generator) for speeding up the work on the remaining APIs!

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
