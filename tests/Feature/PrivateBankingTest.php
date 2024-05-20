<?php

declare(strict_types=1);

use Carbon\Carbon;
use InvestecSdkPhp\Connectors\InvestecConnector;
use InvestecSdkPhp\DataTransferObjects\PrivateBanking\PayMultiple\PayMultipleDto;
use InvestecSdkPhp\DataTransferObjects\PrivateBanking\TransferMultiple\TransferMultipleDto;
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
    $this->privateBankingClient = $connector->privateBanking($authenticator);
});

it('gets accounts', function () {
    /** @var Response $response */
    $response = $this->privateBankingClient->getAccounts();
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
    ->group('private-banking');

it('gets account balance', function () {
    $accountId = $this->privateBankingClient->getAccounts()->json('data.accounts.0')['accountId'];
    $response = $this->privateBankingClient->getAccountBalance($accountId);
    expect($response->status())
        ->toBe(200)
        ->and($response->json())
        ->toBeArray()
        ->toHaveKeys(['data'])
        ->and($response->json('data'))
        ->toHaveCount(4) //Canary if field count changes
        ->toHaveKeys([
            'accountId',
            'currentBalance',
            'availableBalance',
            'currency',
        ]);
})
    ->group('private-banking');

it('gets account transactions', function () {
    $accountId = $this->privateBankingClient->getAccounts()->json('data.accounts.0')['accountId'];
    $fromDate = Carbon::yesterday()->toDateString();
    $toDate = Carbon::today()->toDateString();
    $response = $this->privateBankingClient->getAccountTransactions($accountId, $fromDate, $toDate);
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
    ->group('private-banking');

it('gets beneficiaries', function () {
    /** @var Response $response */
    $response = $this->privateBankingClient->getBeneficiaries();
    expect($response->status())
        ->toBe(200)
        ->and($response->json())
        ->toBeArray()
        ->toHaveKeys(['data'])
        ->and($response->json('data'))
        ->each
        ->toHaveCount(14) //Canary if field count changes
        ->toHaveKeys([
            'beneficiaryId',
            'accountNumber',
            'code',
            'bank',
            'beneficiaryName',
            'lastPaymentAmount',
            'lastPaymentDate',
            'cellNo',
            'emailAddress',
            'name',
            'referenceAccountNumber',
            'referenceName',
            'categoryId',
            'profileId',
        ]);
})
    ->group('private-banking');

it('gets beneficiary categories', function () {
    /** @var Response $response */
    $response = $this->privateBankingClient->getBeneficiaryCategories();
    expect($response->status())
        ->toBe(200)
        ->and($response->json())
        ->toBeArray()
        ->toHaveKeys(['data'])
        ->and($response->json('data'))
        ->each
        ->toHaveCount(3) //Canary if field count changes
        ->toHaveKeys([
            'CategoryId',
            'DefaultCategory',
            'CategoryName',
        ]);
})
    ->group('private-banking');

it('transfers money between accounts', function () {
    $accountIds = array_column($this->privateBankingClient->getAccounts()->json('data.accounts'), 'accountId');
    $accountInstances = [];
    //Only picking two out since there is potential for many transfers to occur here
    foreach (array_slice($accountIds, 1, 2) as $accountId) {
        $accountInstances[] = [
            'beneficiaryAccountId' => $accountId,
            'amount' => 1,
            'myReference' => 'API Transfer',
            'theirReference' => 'API Transfer',
        ];
    }
    $transferMultipleDto = new TransferMultipleDto(['accountInstances' => $accountInstances]);
    /** @var Response $response */
    $response = $this->privateBankingClient->transferMultiple($accountIds[0], $transferMultipleDto);
    expect($response->status())
        ->toBe(200)
        ->and($response->json())
        ->toBeArray()
        ->toHaveKeys(['data.TransferResponses'])
        ->and($response->json('data.TransferResponses'))
        ->each
        ->toHaveCount(6) //Canary if field count changes
        ->toHaveKeys([
            'PaymentReferenceNumber',
            'PaymentDate',
            'Status',
            'BeneficiaryName',
            'BeneficiaryAccountId',
            'AuthorisationRequired',
        ]);
})
    ->group('private-banking');

it('pays money to beneficiaries', function () {
    $accountId = $this->privateBankingClient->getAccounts()->json('data.accounts.0')['accountId'];
    //Only picking two out since there is potential for many payments to occur here
    $beneficiaryIds = array_column(
        array_slice($this->privateBankingClient->getBeneficiaries()->json('data'), 0, 2),
        'beneficiaryId'
    );
    $accountInstances = [];
    foreach ($beneficiaryIds as $beneficiaryId) {
        $accountInstances[] = [
            'beneficiaryId' => $beneficiaryId,
            'amount' => 1,
            'myReference' => 'API Payment',
            'theirReference' => 'API Payment',
        ];
    }
    $payMultipleDto = new PayMultipleDto(['accountInstances' => $accountInstances]);
    /** @var Response $response */
    $response = $this->privateBankingClient->payMultiple($accountId, $payMultipleDto);
    expect($response->status())
        ->toBe(200)
        ->and($response->json())
        ->toBeArray()
        ->toHaveKeys(['data.TransferResponses'])
        ->and($response->json('data.TransferResponses'))
        ->each
        ->toHaveCount(6) //Canary if field count changes
        ->toHaveKeys([
            'PaymentReferenceNumber',
            'PaymentDate',
            'Status',
            'BeneficiaryName',
            'BeneficiaryAccountId',
            'AuthorisationRequired',
        ]);
})
    ->group('private-banking');

it('gets profiles', function () {
    /** @var Response $response */
    $response = $this->privateBankingClient->getProfiles();
    expect($response->status())
        ->toBe(200)
        ->and($response->json())
        ->toBeArray()
        ->toHaveKeys(['data'])
        ->and($response->json('data'))
        ->each
        ->toHaveCount(3) //Canary if field count changes
        ->toHaveKeys([
            'profileId',
            'profileName',
            'defaultProfile',
        ]);
})
    ->group('private-banking');

it('gets profile accounts', function () {
    /** @var Response $response */
    $profileId = $this->privateBankingClient->getProfiles()->json('data')[0]['profileId'];
    $response = $this->privateBankingClient->getProfileAccounts($profileId);
    expect($response->status())
        ->toBe(200)
        ->and($response->json())
        ->toBeArray()
        ->toHaveKeys(['data'])
        ->and($response->json('data'))
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
    ->group('private-banking');

it('gets authorisation setup details', function () {
    /** @var Response $response */
    $profileId = $this->privateBankingClient->getProfiles()->json('data')[0]['profileId'];
    $accountId = $this->privateBankingClient->getProfileAccounts($profileId)->json('data')[0]['accountId'];
    $response = $this->privateBankingClient->getAuthorisationSetupDetails($profileId, $accountId);
    expect($response->status())
        ->toBe(200)
        ->and($response->json())
        ->toBeArray()
        ->toHaveKeys([
            'data.numberOfAuthorisationRequired',
            'data.period',
        ]);
    $authorisersKeyList = [];
    $numberOfLoops = $response->json('data.numberOfAuthorisationRequired') + 1;
    for ($i = 1; $i < $numberOfLoops; $i++) {
        $authorisersKeyList[] = 'data.authorisersList' . strtoupper(chr($i + 96));
    }
    expect($response->json())
        ->toHaveKeys($authorisersKeyList)
        ->and($response->json('data.period'))
        ->toBeArray()
        ->and($response->json('data.period'))
        ->each
        ->toHaveCount(2) //Canary if field count changes
        ->toHaveKeys([
            'id',
            'description',
        ]);
    foreach ($authorisersKeyList as $authoriser) {
        expect($response->json($authoriser))
            ->toBeArray()
            ->each
            ->toHaveCount(2) //Canary if field count changes
            ->toHaveKeys([
                'authoriserId',
                'name',
            ]);
    }
})
    ->group('private-banking');

it('gets profile beneficiaries', function () {
    /** @var Response $response */
    $profileId = $this->privateBankingClient->getProfiles()->json('data')[0]['profileId'];
    $accountId = $this->privateBankingClient->getProfileAccounts($profileId)->json('data')[0]['accountId'];
    $response = $this->privateBankingClient->getProfileBeneficiaries($profileId, $accountId);
    expect($response->status())
        ->toBe(200)
        ->and($response->json())
        ->toBeArray()
        ->toHaveKeys(['data'])
        ->and($response->json('data'))
        ->each
        ->toHaveCount(15) //Canary if field count changes
        ->toHaveKeys([
            'beneficiaryId',
            'accountNumber',
            'code',
            'bank',
            'beneficiaryName',
            'lastPaymentAmount',
            'lastPaymentDate',
            'cellNo',
            'emailAddress',
            'name',
            'referenceAccountNumber',
            'referenceName',
            'categoryId',
            'profileId',
            'fasterPaymentAllowed',
        ]);
})
    ->group('private-banking');

it('gets documents', function () {
    $accountId = $this->privateBankingClient->getAccounts()->json('data.accounts.0')['accountId'];
    //Untested date filters as sandbox has docs from 2023
    $response = $this->privateBankingClient->getDocuments($accountId);
    expect($response->status())
        ->toBe(200)
        ->and($response->json())
        ->toBeArray()
        ->toHaveKeys(['data'])
        ->and($response->json('data'))
        ->each
        ->toHaveCount(2) //Canary if field count changes
        ->toHaveKeys([
            'documentType',
            'documentDate',
        ]);
})
    ->group('private-banking');

//TODO Get document
