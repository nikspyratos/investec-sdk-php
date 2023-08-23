<?php

namespace InvestecSdkPhp\Requests\CardCode;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * PublishFunctionCodeRequest
 *
 * Publish specified code to the specific card. *Note: This will mark the saved code as the published
 * code ready for execution. Remember to specify the {codeid} obtained from the Get Function (saved)
 * code.
 */
class PublishFunctionCodeRequest extends Request
{
    use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/za/v1/cards/{$this->cardKey}/publish";
	}


	/**
	 * @param string $cardKey The CardKey obtained from the get cards call.
	 */
	public function __construct(
		protected string $cardKey,
        protected string $codeId
	) {
	}


	public function defaultQuery(): array
	{
		return ['cardKey' => $this->cardKey];
	}


}
