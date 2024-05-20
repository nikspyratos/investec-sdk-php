<?php

declare(strict_types=1);

use Carbon\Carbon;
use InvestecSdkPhp\Connectors\InvestecConnector;
use InvestecSdkPhp\Enumerations\Environment;
use Saloon\Http\Response;

$connector = null;
$authenticator = null;

beforeAll(function () use (&$connector, &$authenticator) {
    $connector = new InvestecConnector(
        $_ENV['INVESTEC_OPENAPI_CLIENTID'],
        $_ENV['INVESTEC_OPENAPI_SECRET'],
        $_ENV['INVESTEC_OPENAPI_API_KEY'],
        Environment::SANDBOX
    );

    $authenticator = $connector->getAccessToken();
});

beforeEach(function () use (&$connector, &$authenticator) {
    $this->corporateBankingClient = $connector->corporateBanking($authenticator);
});

it('gets accounts', function () {
    /** @var Response $response */
    $response = $this->corporateBankingClient->getAccounts();
    expect($response->status())
        ->toBe(200)
        ->and($response->json())
        ->toBeArray()
        ->toHaveKeys(['data.accounts'])
        ->and($response->json('data.accounts'))
        ->each
        ->toHaveCount(8) //Canary if field count changes
        ->toHaveKeys([
            'accountId',
            'accountNumber',
            'accountName',
            'referenceName',
            'productName',
            'kycCompliant',
            'profileId',
            'profileName',
        ]);
})
    ->skip('18-08-2023 Sandbox credentials for CIB seem to not be working')
    ->group('corporate-banking');

it('gets account transactions', function () {
    $accountIdentifier = $this->corporateBankingClient->getAccounts()->json('data.accounts.0')['accountId'];
    $fromDate = Carbon::yesterday()->toDateString();
    $toDate = Carbon::today()->toDateString();
    $response = $this->corporateBankingClient->getAccountTransactions($accountIdentifier, $fromDate, $toDate);
    expect($response->status())
        ->toBe(200)
        ->and($response->json())
        ->toBeArray()
        ->toHaveKeys(['data.transactions'])
        ->and($response->json('data.transactions'))
        ->each
        ->toHaveCount(13) //Canary if field count changes
        ->toHaveKeys([
            'accountId',
            'type',
            'transactionType',
            'status',
            'description',
            'cardNumber',
            'postedOrder',
            'postingDate',
            'valueDate',
            'actionDate',
            'transactionDate',
            'amount',
            'runningBalance',
        ]);
})
    ->skip('18-08-2023 Sandbox credentials for CIB seem to not be working')
    ->group('corporate-banking');
