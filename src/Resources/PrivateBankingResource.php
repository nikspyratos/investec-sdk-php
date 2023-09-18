<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Resources;

use InvestecSdkPhp\DataTransferObjects\PrivateBanking\PayMultiple\PayMultipleDto;
use InvestecSdkPhp\DataTransferObjects\PrivateBanking\TransferMultiple\TransferMultipleDto;
use InvestecSdkPhp\Enumerations\TransactionType;
use InvestecSdkPhp\Requests\PrivateBanking\GetAccountBalanceRequest;
use InvestecSdkPhp\Requests\PrivateBanking\GetAccountBeneficiariesRequest;
use InvestecSdkPhp\Requests\PrivateBanking\GetAccountsRequest;
use InvestecSdkPhp\Requests\PrivateBanking\GetAccountTransactionsRequest;
use InvestecSdkPhp\Requests\PrivateBanking\GetAuthorisationSetupDetails;
use InvestecSdkPhp\Requests\PrivateBanking\GetBeneficiaryCategoriesRequest;
use InvestecSdkPhp\Requests\PrivateBanking\GetDocument;
use InvestecSdkPhp\Requests\PrivateBanking\GetDocuments;
use InvestecSdkPhp\Requests\PrivateBanking\GetProfileAccounts;
use InvestecSdkPhp\Requests\PrivateBanking\GetProfileBeneficiaries;
use InvestecSdkPhp\Requests\PrivateBanking\GetProfiles;
use InvestecSdkPhp\Requests\PrivateBanking\PayMultipleRequest;
use InvestecSdkPhp\Requests\PrivateBanking\TransferMultipleV2Request;
use Saloon\Contracts\Connector;
use Saloon\Contracts\OAuthAuthenticator;
use Saloon\Http\Response;

class PrivateBankingResource extends Resource
{
    public function __construct(Connector $connector, OAuthAuthenticator $authenticator)
    {
        parent::__construct($connector);
        $this->connector->authenticate($authenticator);
    }

    public function getAccounts(): Response
    {
        return $this->connector->send(new GetAccountsRequest);
    }

    public function getAccountBalance(string $accountIdentifier): Response
    {
        return $this->connector->send(new GetAccountBalanceRequest($accountIdentifier));
    }

    public function getAccountTransactions(string $accountIdentifier, ?string $fromDate = null, ?string $toDate = null, ?TransactionType $transactionType = null): Response
    {
        return $this->connector->send(new GetAccountTransactionsRequest($accountIdentifier, $fromDate, $toDate, $transactionType));
    }

    public function transferMultiple(string $accountIdentifier, TransferMultipleDto $transferMultipleDTO): Response
    {
        return $this->connector->send(new TransferMultipleV2Request($accountIdentifier, $transferMultipleDTO));
    }

    public function payMultiple(string $accountIdentifier, PayMultipleDto $payMultipleDto): Response
    {
        return $this->connector->send(new PayMultipleRequest($accountIdentifier, $payMultipleDto));
    }

    public function getBeneficiaries(): Response
    {
        return $this->connector->send(new GetAccountBeneficiariesRequest);
    }

    public function getBeneficiaryCategories(): Response
    {
        return $this->connector->send(new GetBeneficiaryCategoriesRequest);
    }

    public function getProfiles(): Response
    {
        return $this->connector->send(new GetProfiles);
    }

    public function getProfileAccounts(string $profileId): Response
    {
        return $this->connector->send(new GetProfileAccounts($profileId));
    }

    public function getAuthorisationSetupDetails(string $profileId, string $accountId): Response
    {
        return $this->connector->send(new GetAuthorisationSetupDetails($profileId, $accountId));

    }

    public function getProfileBeneficiaries(string $profileId, string $accountId): Response
    {
        return $this->connector->send(new GetProfileBeneficiaries($profileId, $accountId));
    }

    public function getDocuments(string $accountId, ?string $fromDate = null, ?string $toDate = null): Response
    {
        return $this->connector->send(new GetDocuments($accountId));
    }

    public function getDocument(string $accountId, string $documentType, string $documentDate): Response
    {
        return $this->connector->send(new GetDocument($accountId, $documentType, $documentDate));
    }
}
