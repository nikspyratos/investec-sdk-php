<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Introducers;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Traits\Body\HasJsonBody;

/**
 * AddIntroducer
 *
 * Creates a new introducer.
 */
class CreateIntroducer extends IntermediaryRequest implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $intermediaryId,
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
            ],
        ];
    }
}
