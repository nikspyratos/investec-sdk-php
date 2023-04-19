<?php

namespace InvestecSdkPhp\Requests\PrivateBanking;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetAccountBeneficiariesRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/za/pb/v1/accounts/beneficiaries';
    }
}
