<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Intermediaries;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Enums\Method;

/**
 * GetLinkedProfiles
 *
 * Returns a list of intermediaries linked to the authorised token.
 */
class GetIntermediaries extends IntermediaryRequest
{
    protected Method $method = Method::GET;

    public function __construct(protected string $intermediaryId)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/za/ifi/v1/intermediaries';
    }
}
