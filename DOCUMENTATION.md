# Documentation

<!-- TOC -->
* [Documentation](#documentation)
  * [Links](#links)
  * [Setup](#setup)
    * [Environments](#environments)
    * [Data Transfer Objects](#data-transfer-objects)
    * [Internal use](#internal-use)
    * [External use](#external-use)
    * [Authentication scopes](#authentication-scopes)
  * [Available APIs](#available-apis)
    * [Private Banking](#private-banking)
      * [Get Accounts](#get-accounts)
      * [Get Account Balance](#get-account-balance)
      * [Get Account Transactions](#get-account-transactions)
      * [Transfer Multiple](#transfer-multiple)
      * [Pay Multiple](#pay-multiple)
      * [Get Beneficiaries](#get-beneficiaries)
      * [Get Beneficiary Categories](#get-beneficiary-categories)
      * [Get Profiles](#get-profiles)
      * [Get Profile Accounts](#get-profile-accounts)
      * [Get Authorisation Setup Details](#get-authorisation-setup-details)
      * [Get Profile Beneficiaries](#get-profile-beneficiaries)
      * [Get Documents](#get-documents)
      * [Get Document](#get-document)
    * [Card Code](#card-code)
      * [Get Cards](#get-cards)
      * [Get Function (Saved) Code](#get-function-saved-code)
      * [Get Function (Published) Code](#get-function-published-code)
      * [Get Code Executions](#get-code-executions)
      * [Get Environment Variables](#get-environment-variables)
      * [Get Countries](#get-countries)
      * [Get Currencies](#get-currencies)
      * [Get Merchants](#get-merchants)
      * [Update Function Code](#update-function-code)
      * [Publish Saved Code](#publish-saved-code)
      * [Execute Simulated Function Code](#execute-simulated-function-code)
      * [Replace Environment Variables](#replace-environment-variables)
      * [Toggle Programmable Card Feature](#toggle-programmable-card-feature)
    * [Corporate and Institutional Banking](#corporate-and-institutional-banking)
      * [Get Accounts](#get-accounts-1)
      * [Get Account Transactions](#get-account-transactions-1)
    * [CIB for Intermediaries](#cib-for-intermediaries)
      * [Accounts](#accounts)
      * [Banks](#banks)
      * [Categories](#categories)
      * [Client Details](#client-details)
      * [Intermediaries](#intermediaries)
      * [Introducers](#introducers)
  * [Intermediary Forex Settlement](#intermediary-forex-settlement)
    * [BOP Reports](#bop-reports)
      * [Get BOP Reports by type](#get-bop-reports-by-type)
      * [Get BOP Reports by transaction reference](#get-bop-reports-by-transaction-reference)
      * [Update BOP Report](#update-bop-report)
      * [Validate BOP Report](#validate-bop-report)
      * [Get BOP Report Supporting Documents](#get-bop-report-supporting-documents)
      * [Upload file contents for document handle](#upload-file-contents-for-document-handle)
      * [Retrieve base64 of supporting document](#retrieve-base64-of-supporting-document)
      * [Perform action on BOP Report](#perform-action-on-bop-report)
    * [Forex](#forex)
  * [Tips & Hints](#tips--hints)
    * [Current balance vs Available balance](#current-balance-vs-available-balance)
    * [Transaction dates: posting date, value date, action date, transaction date](#transaction-dates-posting-date-value-date-action-date-transaction-date)
    * [Transaction types](#transaction-types)
    * [Beneficiary Categories](#beneficiary-categories)
<!-- TOC -->

## Links

- [API documentation](https://developer.investec.com/za/api-products)
- [Investec Programmable Banking Communiti Wiki](https://offerzen.gitbook.io/programmable-banking-community-wiki/home/readme)

## Setup

If you're accessing your own account data (either as an individual or corporate), see [Internal use](#internal-use). If you're accessing Investec customer data, see [External use](#external-use).

See the the API documentation for response contents.

### Environments

The API offers two environments: Sandbox and Production.

By default this SDK will use the Production environment. To change this, you may specify the environment using the provided enum like so:

```php
use InvestecSdkPhp\Enumerations\Environment;
$connector = new InvestecConnector($clientId, $clientSecret, Environment::SANDBOX);
```

The Sandbox API also has public credentials for testing with. Consult the API documentation for details.

### Data Transfer Objects

For `Transfer Multiple` and `Pay Multiple` endpoints, arrays of beneficiaries/accounts are accepted.

To handle this in a structured manner this package uses `dragon-code/simple-dto` to build the DTOs with the required data.

### Internal use

Firstly, make sure you've [obtained your API credentials](https://offerzen.gitbook.io/programmable-banking-community-wiki/get-started/api-quick-start-guide#how-to-get-your-api-keys) - this is how you get your client ID, secret and API key.

Note: Internal use access tokens have a lifespan of 30 minutes.

```php
use InvestecSdkPhp\Connectors\InvestecConnector;

$clientId = '';
$clientSecret = '';
$apiKey = '';

//Initialise the API Connector
$connector = new InvestecConnector($clientId, $clientSecret, $apiKey);

//Get an access token
$authenticator = $connector->getAccessToken();

//Now you can make requests to the appropriate API section, .e.g Private Banking
$api = $connector->privateBanking($authenticator);
```

To customise the access token's API scope, you can do so in the `getAccessToken` call:
```php
//...
$authenticator = $connector->getAccessToken(['accounts', 'transactions']);
```

### External use

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

//Now you can make requests to the appropriate API section, .e.g Private Banking
$api = $connector->privateBanking($authenticator);
```

To customise the access token's API scope, you can do so in the `getAuthorizationUrl` call:
```php
//...
$authUrl = $connector->getAuthorizationUrl($redirectUri, ['accounts', 'transactions']);
//...
```

### Authentication scopes

In the Personal & External use examples above, you're able to specify which scopes you'll be using for this access token.

For Internal use, you'll need to enable the relevant scope permission when you generate your API key. See [Internal use](#internal-use) for more information.

The scopes available are:
```
accounts
balances
beneficiarypayments
cards
statements
taxcertificates
transactions
transfers
```

By default only the `accounts` scope is used. To change the scopes used, you can do this:

```php
$scopes = [...]; //your scopes here
$connector->oauthConfig()->setDefaultScopes($scopes);
```

## Available APIs

### Private Banking

#### Get Accounts

```php
$api->getAccounts();
```

Will return an array of accounts. Each of these will contain an `accountNumber` and an `accountId`. The former is the bankingaccount number, and the latter is the internal ID of the account (this is the one to use in the API).

#### Get Account Balance

```php
$api->getAccountBalance($accountIdentifier);
```

- `$accountIdentifier` is the internal identifier from the `getAccounts` request.

Returns an object containing the account ID, current balance, available balance, and currency.

#### Get Account Transactions

```php
$api->getAccountTransactions($accountIdentifier, $fromDate, $toDate);
```

- `$accountIdentifier` is the internal identifier from the `getAccounts` request.
- `$fromDate` and `$toDate` are optional filtering parameters that filter against the transactions' `postingDate`. The expected date format is `YYYY-MM-DD`, e.g. `2021-05-01`.
- `$transactionType` is an optional filtering parameter. It maps onto Investec's base transaction types. Use the `InvestecSdkPhp\Enumerations\TransactionType` enumeration here.  

Returns an array of transactions.

#### Transfer Multiple

Uses the V2 version of this endpoint. Support for the deprecated endpoint is not planned.

The endpoint accepts a list of objects to handle multiple transfers.

```php
use \InvestecSdkPhp\DataTransferObjects\PrivateBanking\TransferMultiple\TransferMultipleDto;
$transferMultipleDto = new TransferMultiple\TransferMultipleDto([
    'accountInstances' => [
        [
            'beneficiaryAccountId' => 'XXXX',
            'amount' => 100, //Remember - this is NOT in cents!
            'myReference' => 'API Transfer',
            'theirReference' => 'API Transfer',
        ]
        // ...
    ]
]);
$api->transferMultiple($accountIdentifier, $transferMultipleDto);
```

- `$accountIdentifier` is the internal identifier from the `getAccounts` request.
 
Transfers money between accounts.

#### Pay Multiple

The endpoint accepts a list of objects to handle multiple transfers.

```php
use \InvestecSdkPhp\DataTransferObjects\PrivateBanking\PayMultiple\PayMultipleDto;
$payMultipleDto = new PayMultiple\PayMultipleDto([
    'accountInstances' => [
        [
            'beneficiaryId' => 'XXXX',
            'amount' => 100, //Remember - this is NOT in cents!
            'myReference' => 'API Transfer',
            'theirReference' => 'API Transfer',
        ]
        // ...
    ]
]);
$api->payMultiple($accountIdentifier, $payMultipleDto);
```

- `$accountIdentifier` is the internal identifier from the `getAccounts` request.

Used to pay beneficiaries.

#### Get Beneficiaries

```php
$api->getBeneficiaries();
```

Returns an array of beneficiaries that have been linked to the user's profile.

#### Get Beneficiary Categories

```php
$api->getBeneficiaryCategories();
```

Returns an array of the beneficiary categories used on the profile. It will also show which one is the default one.

#### Get Profiles

```php
$api->getProfiles();
```

Lists all profiles.

#### Get Profile Accounts

```php
$api->getProfileAccounts($profileId);
```

Lists accounts for the given profile.

#### Get Authorisation Setup Details

```php
$api->getAuthorisationSetupDetails($profileId, $accountId);
```

List the authorisation setup details for the specified profile and accounts.

#### Get Profile Beneficiaries

```php
$api->getProfileBeneficiaries($profileId, $accountId);
```

Lists beneficiaries available to the given profile & account.

#### Get Documents

**Note**: This and [Get Document](#get-document) both require your API token to have the `taxcertificates` or `statements` scopes.

```php
$api->getDocuments($accountId, $fromDate, $toDate);
```

Lists available documents in the given date range. Otherwise defaults to documents available in the last month until today.

#### Get Document

```php
$api->getDocument($accountId, $documentType, $documentDate);
```

Retrieves the specified document type using the account ID, docuemnt type and date.

### Card Code

#### Get Cards

#### Get Function (Saved) Code

#### Get Function (Published) Code

#### Get Code Executions

#### Get Environment Variables

#### Get Countries

#### Get Currencies

#### Get Merchants

#### Update Function Code

#### Publish Saved Code

#### Execute Simulated Function Code

#### Replace Environment Variables

#### Toggle Programmable Card Feature

### Corporate and Institutional Banking

#### Get Accounts

#### Get Account Transactions

### CIB for Intermediaries

**Note**: According to the documentation, this API is only available via the 3-legged OAuth API (i.e. business use for clients), so it is only made available through the `InvesteOAuthConnector` class. 

#### Accounts

#### Banks

#### Categories

#### Client Details

#### Intermediaries

#### Introducers

## Intermediary Forex Settlement

**Note**: It's unclear if this API is only available for internal or external use. For now, it is added to both connectors.

### BOP Reports

#### Get BOP Reports by type

#### Get BOP Reports by transaction reference

#### Update BOP Report

Not yet implemented.

#### Validate BOP Report

Not yet implemented.

#### Get BOP Report Supporting Documents

#### Upload file contents for document handle

Not yet implemented.

#### Retrieve base64 of supporting document

#### Perform action on BOP Report

**Note**: The only current valid value for `action` is `Approve`.

### Forex

## Tips & Hints

### Current balance vs Available balance
 
Investec accounts (at least consumer ones by default) have a credit/overdraft facility, which is why you'll see `currentBalance` and `availableBalance` have large differences.

### Transaction dates: posting date, value date, action date, transaction date

- `postingDate` is the date the transaction affects your balance, and is the one used for filtering.
- `transactionDate` is the date the transaction physically occurred, e.g. when the card was swiped.

Currently I don't know the difference with value date and action date compared to the above two.

### Transaction types

Investec has its own transaction types that all transactions automatically fall into:
- Card Purchases
- ATM Withdrawals
- Online Banking Payments
- Deposits
- Debit Orders
- Budget Instalments
- Faster Pay
- Fees And Interest

This package provides a `TransactionType` enum for convenience.

### Beneficiary Categories

These categories are user-created in their Investec app/online banking. By default the only category is `Not Categorised`.
