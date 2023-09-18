<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Categories;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Enums\Method;

/**
 * DeleteCategory
 *
 * Deletes a category using the parameterised category Id for the parameterised intermediaryId.
 */
class DeleteCategory extends IntermediaryRequest
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $intermediaryId,
        protected string $categoryId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/za/ifi/v1/intermediaries/categories/{$this->categoryId}";
    }
}
