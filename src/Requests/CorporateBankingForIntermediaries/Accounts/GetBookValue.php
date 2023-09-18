<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Accounts;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Enums\Method;

/**
 * GetTotalBookValues
 *
 * Returns the book value for each currency.
 */
class GetBookValue extends IntermediaryRequest
{
    protected Method $method = Method::GET;

    public function __construct(protected string $intermediaryId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/za/ifi/v1/accounts/book-value';
    }
}
