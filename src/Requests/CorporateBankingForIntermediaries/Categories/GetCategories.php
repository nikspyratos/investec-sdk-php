<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Categories;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Enums\Method;

/**
 * GetCategories
 *
 * Returns a list of categories for the parameterised intermediaryId.
 */
class GetCategories extends IntermediaryRequest
{
    protected Method $method = Method::GET;

    public function __construct(protected string $intermediaryId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/za/ifi/v1/intermediaries/categories';
    }
}
