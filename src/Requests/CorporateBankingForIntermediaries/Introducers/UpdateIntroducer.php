<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Introducers;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Traits\Body\HasJsonBody;

/**
 * AmendIntroducer
 *
 * Updates the parameterised introducer
 */
class UpdateIntroducer extends IntermediaryRequest implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function __construct(
        protected string $intermediaryId,
        protected string $introducerId,
        protected string $introducerOldName,
        protected string $introducerName
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/za/ifi/v1/introducers';
    }

    protected function defaultBody(): array
    {
        return [
            'data' => [
                'introducerName' => $this->introducerName,
                'introducerId' => $this->introducerId,
                'introducerOldName' => $this->introducerOldName,
            ],
        ];
    }
}
