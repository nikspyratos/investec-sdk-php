<?php

namespace InvestecSdkPhp\Requests\CardCode;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetMerchantsRequest
 *
 * Get a reference set of merchant category codes and descriptions.
 */
class GetMerchantsRequest extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/za/v1/cards/merchants";
	}


	public function __construct()
	{
	}
}
