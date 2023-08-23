<?php

namespace InvestecSdkPhp\Requests\CardCode;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetCardsRequest
 *
 * Obtain cards associated with the account.
 */
class GetCardsRequest extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/za/v1/cards";
	}


	public function __construct()
	{
	}
}
