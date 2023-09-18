<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Accounts;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Traits\Body\HasJsonBody;

/**
 * GetAccountBalance
 *
 * Returns a list of account balances for the posted account numbers.
 */
class GetAccountBalances extends IntermediaryRequest implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(protected string $intermediaryId, protected array $accountIds)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/za/ifi/v1/accounts/balance';
    }

    protected function defaultBody(): array
    {
        return [
            'data' => [
                'accountNumbers' => $this->accountIds,
            ],
        ];
    }
}
