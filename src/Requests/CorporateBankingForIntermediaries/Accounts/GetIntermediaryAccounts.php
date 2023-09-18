<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Accounts;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Enums\Method;

/**
 * GetIntermedairyAccounts
 *
 * Returns the Main and Income account for the parameterised intermediaryId.
 */
class GetIntermediaryAccounts extends IntermediaryRequest
{
    protected Method $method = Method::GET;

    public function __construct(protected string $intermediaryId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/za/ifi/v1/accounts/intermediary';
    }
}
