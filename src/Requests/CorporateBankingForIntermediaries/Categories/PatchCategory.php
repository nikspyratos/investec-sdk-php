<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Categories;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Traits\Body\HasJsonBody;

/**
 * AmendCategory
 *
 * Patch an existing category for the parameterised intermediaryId and categoryId.
 */
class PatchCategory extends IntermediaryRequest implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected string $intermediaryId,
        protected ?string $id,
        protected ?string $name
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/za/ifi/v1/intermediaries/categories';
    }

    protected function defaultBody(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
