<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CardCode;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * UpdateFunctionEnvironmentVariablesRequest
 *
 * Sets the environment variables stored agains a spesific card. Note: This replaces all variables and
 * does not allow for patching.
 */
class UpdateFunctionEnvironmentVariablesRequest extends Request
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $cardKey The CardKey obtained from the get cards call.
     */
    public function __construct(
        protected string $cardKey,
        protected array $variables
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/za/v1/cards/{$this->cardKey}/environmentvariables";
    }

    public function defaultQuery(): array
    {
        return ['cardKey' => $this->cardKey];
    }

    protected function defaultBody(): array
    {
        return [
            'variables' => $this->variables,
        ];
    }
}
