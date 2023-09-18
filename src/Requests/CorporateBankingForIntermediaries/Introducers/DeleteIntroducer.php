<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Introducers;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Enums\Method;

/**
 * DeleteIntroducer
 *
 * Deletes the parameterised introducer.
 */
class DeleteIntroducer extends IntermediaryRequest
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $intermediaryId,
        protected string $introducerId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/za/ifi/v1/introducers/{$this->introducerId}";
    }
}
