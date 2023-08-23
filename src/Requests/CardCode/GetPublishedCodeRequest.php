<?php

namespace InvestecSdkPhp\Requests\CardCode;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetPublishedCodeRequest
 *
 * Obtain code currently published to the specific card.
 */
class GetPublishedCodeRequest extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/za/v1/cards/{$this->cardKey}/publishedcode";
	}


	/**
	 * @param string $cardKey The CardKey obtained from the get cards call.
	 */
	public function __construct(
		protected string $cardKey,
	) {
	}


	public function defaultQuery(): array
	{
		return ['cardKey' => $this->cardKey];
	}
}
