<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CardCode;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetCountriesRequest
 *
 * Gets a reference set of countries.
 */
class GetCountriesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct()
    {
    }

    public function resolveEndpoint(): string
    {
        return '/za/v1/cards/countries';
    }
}
