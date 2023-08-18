<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\PrivateBanking;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetBeneficiaryCategoriesRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/za/pb/v1/accounts/beneficiarycategories';
    }
}
