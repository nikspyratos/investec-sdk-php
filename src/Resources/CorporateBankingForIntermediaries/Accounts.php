<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Resources\CorporateBankingForIntermediaries;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Accounts\GetAccountBalances;
use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Accounts\GetAccountDetails;
use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Accounts\GetAccountsByType;
use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Accounts\GetBookValue;
use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Accounts\GetClientAccounts;
use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Accounts\GetClientRateAndAdminFee;
use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Accounts\GetIntermediaryAccounts;
use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Accounts\GetPendingTransactions;
use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Accounts\GetTransactionsHistory;
use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Accounts\SearchAccounts;
use InvestecSdkPhp\Resource;
use ReflectionException;
use Saloon\Contracts\Response;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;

class Accounts extends Resource
{
    /**
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     * @throws ReflectionException
     */
    public function getPendingTransactions(string $intermediaryId, string $accountNumber): Response
    {
        return $this->connector->send(new GetPendingTransactions($intermediaryId, $accountNumber));
    }

    /**
     * @param  int|null  $page Must be greater than 0
     * @param  int|null  $pageSize Min = 10, Max = 100
     * @param  string|null  $startDate dd-MM-yyyy
     * @param  string|null  $endDate dd-MM-yyyy
     * @param  string|null  $sort asc/desc
     *
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public function getTransactionsHistory(
        string $intermediaryId,
        int $accountNumber,
        ?int $page,
        ?int $pageSize,
        ?string $startDate,
        ?string $endDate,
        ?string $sort,
    ): Response {
        return $this->connector->send(new GetTransactionsHistory($intermediaryId, $accountNumber, $page, $pageSize, $startDate, $endDate, $sort));
    }

    /**
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public function getAccountBalance(string $intermediaryId): Response
    {
        return $this->connector->send(new GetAccountBalances($intermediaryId));
    }

    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws PendingRequestException
     */
    public function getIntermedairyAccounts(string $intermediaryId): Response
    {
        return $this->connector->send(new GetIntermediaryAccounts($intermediaryId));
    }

    /**
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     * @throws ReflectionException
     */
    public function getNetRates(string $intermediaryId, string $accountNumber): Response
    {
        return $this->connector->send(new GetClientRateAndAdminFee($intermediaryId, $accountNumber));
    }

    /**
     * @param  string  $accountStatus Must be 'Open' or 'Closed'
     * @param  int|null  $page Must be greater than 0
     * @param  int|null  $pageSize Min = 10, Max = 100
     *
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     * @throws ReflectionException
     */
    public function getUnderlyingAccounts(string $intermediaryId, string $accountStatus, ?int $page, ?int $pageSize): Response
    {
        return $this->connector->send(new GetClientAccounts($intermediaryId, $accountStatus, $page, $pageSize));
    }

    /**
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public function getTotalBookValues(string $intermediaryId): Response
    {
        return $this->connector->send(new GetBookValue($intermediaryId));
    }

    /**
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     * @throws ReflectionException
     */
    public function getAccountDetails(string $intermediaryId, string $accountNumber): Response
    {
        return $this->connector->send(new GetAccountDetails($intermediaryId, $accountNumber));
    }

    /**
     * @param  string  $accountStatus 'Open' => OPEN Accounts | 'Closed' => CLOSED Accounts
     * @param  int|null  $page Must be greater than 0
     * @param  int|null  $pageSize Min = 10, Max = 100
     *
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     * @throws ReflectionException
     */
    public function getAccountsSearch(string $intermediaryId, string $accountStatus, string $keyword, ?int $page, ?int $pageSize): Response
    {
        return $this->connector->send(new SearchAccounts($intermediaryId, $accountStatus, $keyword, $page, $pageSize));
    }

    /**
     * @param  string  $accountType Must be 'beneficiary-payment', 'ad-hoc-payment', 'scheduled-payment' or 'interest-instruction'
     * @param  string|null  $keyword Search filter keyword
     * @param  string|null  $categoryId Category-id filter key
     * @param  int|null  $page Must be greater than 0
     * @param  int|null  $pageSize Min = 10, Max = 100
     *
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     * @throws ReflectionException
     */
    public function getPaymentAccountsByIntermediary(
        string $intermediaryId,
        string $accountType,
        ?string $keyword,
        ?string $categoryId,
        ?int $page,
        ?int $pageSize,
    ): Response {
        return $this->connector->send(new GetAccountsByType($intermediaryId, $accountType, $keyword, $categoryId, $page, $pageSize));
    }
}
