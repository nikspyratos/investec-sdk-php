<?php

namespace InvestecSdkPhp\Requests\CardCode;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetCurrenciesRequest
 *
 * Gets a reference set of currencies.
 */
class GetCurrenciesRequest extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/za/v1/cards/currencies";
	}


	public function __construct()
	{
	}
}
