<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CardCode;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetFunctionCodeRequest
 *
 * Obtain code currently saved to the specific card.
 */
class GetFunctionCodeRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $cardKey The CardKey obtained from the get cards call.
     */
    public function __construct(
        protected string $cardKey,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/za/v1/cards/{$this->cardKey}/code";
    }

    public function defaultQuery(): array
    {
        return ['cardKey' => $this->cardKey];
    }
}
