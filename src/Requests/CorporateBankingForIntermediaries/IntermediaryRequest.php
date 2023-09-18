<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries;

use Saloon\Http\Request;

abstract class IntermediaryRequest extends Request
{
    protected string $intermediaryId;

    abstract public function resolveEndpoint(): string;

    protected function defaultHeaders(): array
    {
        return [
            'intermediaryId' => $this->intermediaryId,
        ];
    }
}
