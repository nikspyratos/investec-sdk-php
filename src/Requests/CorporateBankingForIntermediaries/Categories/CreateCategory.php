<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Categories;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateCategory
 *
 * Creates a new category for the parameterised intermediaryId and categoryId.
 */
class CreateCategory extends IntermediaryRequest implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $intermediaryId,
        protected ?string $name = null
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/za/ifi/v1/intermediaries/categories';
    }

    protected function defaultBody(): array
    {
        return [
            'name' => $this->name,
        ];
    }
}
