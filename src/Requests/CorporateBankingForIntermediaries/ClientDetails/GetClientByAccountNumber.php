<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\ClientDetails;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Enums\Method;

/**
 * GetClientDetailsByAccountNumber
 *
 * Returns the client details for the parameterised account number.
 */
class GetClientByAccountNumber extends IntermediaryRequest
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $intermediaryId,
        protected string $accountNumber,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/za/ifi/v1/clients/accounts/{$this->accountNumber}/client-detail";
    }
}
