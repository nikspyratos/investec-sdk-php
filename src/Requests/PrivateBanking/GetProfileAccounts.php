<?php

namespace InvestecSdkPhp\Requests\PrivateBanking;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetProfileAccounts extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/za/pb/v1/profiles/{$this->profileId}/accounts";
    }

    public function __construct(protected string $profileId)
    {
    }
}
