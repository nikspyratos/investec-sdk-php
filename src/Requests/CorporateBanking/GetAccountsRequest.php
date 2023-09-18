<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBanking;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetAccountsRequest
 *
 * Obtain a list of accounts with balances in associated profile.
 */
class GetAccountsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct()
    {
    }

    public function resolveEndpoint(): string
    {
        return '/za/bb/v1/accounts';
    }
}
