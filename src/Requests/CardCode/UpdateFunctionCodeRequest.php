<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CardCode;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * UpdateFunctionCodeRequest
 *
 * Save specified code to the specific card. Note: This allows you to save/stage the code to the card
 * without publishing it. This implies that the code will not execute when a card transaction occurs.
 */
class UpdateFunctionCodeRequest extends Request
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $cardKey The CardKey obtained from the get cards call.
     */
    public function __construct(
        protected string $cardKey,
        protected string $code
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/za/v1/cards/{$this->cardKey}/code";
    }

    protected function defaultBody(): array
    {
        return ['code' => $this->code];
    }
}
