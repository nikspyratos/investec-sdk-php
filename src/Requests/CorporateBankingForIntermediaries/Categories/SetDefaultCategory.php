<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Categories;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Traits\Body\HasJsonBody;

/**
 * SetDefaultCategory
 *
 * Sets the parameterised categoryId as the intermediary default category for the parameterised
 * intermediaryId.
 */
class SetDefaultCategory extends IntermediaryRequest implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $intermediaryId,
        protected string $categoryId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/za/ifi/v1/intermediaries/categories/default/{$this->categoryId}";
    }
}
