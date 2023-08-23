<?php

namespace InvestecSdkPhp\Requests\CardCode;

use InvestecSdkPhp\DataTransferObjects\CardCode\ExecuteFunctionCodeDto;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * ExecuteFunctionCodeRequest
 *
 * Publish specified code to the specific card. Note: This allows you to push code to the specified
 * card. After successfully publishing the code it will execute the next time a card transaction
 * occurs.
 */
class ExecuteFunctionCodeRequest extends Request
{
    use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/za/v1/cards/{$this->cardKey}/code/execute";
	}


	/**
	 * @param string $cardKey The CardKey obtained from the get cards call.
	 */
	public function __construct(
		protected string $cardKey,
        protected ExecuteFunctionCodeDto $executeFunctionCodeDto
	) {
	}


	public function defaultQuery(): array
	{
		return ['cardKey' => $this->cardKey];
	}

    protected function defaultBody(): array
    {
        return $this->executeFunctionCodeDto->toArray();
    }
}
