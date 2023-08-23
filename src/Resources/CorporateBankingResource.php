<?php

namespace InvestecSdkPhp\Resources;

use InvestecSdkPhp\Enumerations\TransactionType;
use InvestecSdkPhp\Requests\CorporateBanking\GetAccountsRequest;
use InvestecSdkPhp\Requests\CorporateBanking\GetAccountTransactionsRequest;
use Saloon\Http\Response;

class CorporateBankingResource extends Resource
{
    public function getAccounts(): Response
    {
        return $this->connector->send(new GetAccountsRequest);
    }

    public function getAccountTransactions(string $accountIdentifier, ?string $fromDate = null, ?string $toDate = null, ?TransactionType $transactionType = null): Response
    {
        return $this->connector->send(new GetAccountTransactionsRequest($accountIdentifier, $fromDate, $toDate, $transactionType));
    }
}
