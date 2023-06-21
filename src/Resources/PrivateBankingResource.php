<?php

namespace InvestecSdkPhp\Resources;

use InvestecSdkPhp\DataTransferObjects\PrivateBanking\PayMultiple\PayMultipleDto;
use InvestecSdkPhp\DataTransferObjects\PrivateBanking\TransferMultiple\TransferMultipleDto;
use InvestecSdkPhp\Enumerations\TransactionType;
use InvestecSdkPhp\Requests\PrivateBanking\GetAccountBalanceRequest;
use InvestecSdkPhp\Requests\PrivateBanking\GetAccountBeneficiariesRequest;
use InvestecSdkPhp\Requests\PrivateBanking\GetAccountsRequest;
use InvestecSdkPhp\Requests\PrivateBanking\GetAccountTransactionsRequest;
use InvestecSdkPhp\Requests\PrivateBanking\GetBeneficiaryCategoriesRequest;
use InvestecSdkPhp\Requests\PrivateBanking\PayMultiple;
use InvestecSdkPhp\Requests\PrivateBanking\TransferMultipleV2;
use Saloon\Contracts\Authenticator;
use Saloon\Contracts\Connector;
use Saloon\Http\Response;

class PrivateBankingResource extends Resource
{
    public function __construct(Connector $connector, Authenticator $authenticator)
    {
        parent::__construct($connector);
        $this->connector->authenticate($authenticator);
    }

    public function getAccounts(): Response
    {
        return $this->connector->send(new GetAccountsRequest());
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
        return $this->connector->send(new TransferMultipleV2($accountIdentifier, $transferMultipleDTO));
    }

    public function payMultiple(string $accountIdentifier, PayMultipleDto $payMultipleDto): Response
    {
        return $this->connector->send(new PayMultiple($accountIdentifier, $payMultipleDto));
    }

    public function getBeneficiaries(): Response
    {
        return $this->connector->send(new GetAccountBeneficiariesRequest());
    }

    public function getBeneficiaryCategories(): Response
    {
        return $this->connector->send(new GetBeneficiaryCategoriesRequest());
    }
}
