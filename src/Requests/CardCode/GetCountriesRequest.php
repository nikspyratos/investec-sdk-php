<?php

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


	public function resolveEndpoint(): string
	{
		return "/za/v1/cards/countries";
	}


	public function __construct()
	{
	}
}
