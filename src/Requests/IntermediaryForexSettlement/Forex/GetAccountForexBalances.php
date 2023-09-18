<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\IntermediaryForexSettlement\Forex;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Retrieves forex allowance balances for the provided account number
 */
class GetAccountForexBalances extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $accountNo,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/za/ifi/v1/forex/allowances/{$this->accountNo}/balance";
    }
}
