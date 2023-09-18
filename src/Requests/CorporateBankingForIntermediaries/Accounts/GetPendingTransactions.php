<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Accounts;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Enums\Method;

/**
 * GetPendingTransactions
 *
 * Returns a list of pending transactions for the parameterised account number.
 */
class GetPendingTransactions extends IntermediaryRequest
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $intermediaryId,
        protected string $accountNumber,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/za/ifi/v1/accounts/{$this->accountNumber}/pending-transactions";
    }
}
