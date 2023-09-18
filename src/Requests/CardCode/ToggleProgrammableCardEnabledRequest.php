<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CardCode;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * ToggleProgrammableCardEnabledRequest
 *
 * Toggle the programmable feature for a specific card.
 */
class ToggleProgrammableCardEnabledRequest extends Request
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $cardKey The CardKey obtained from the get cards call.
     */
    public function __construct(
        protected string $cardKey,
        protected bool $enabled
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/za/v1/cards/{$this->cardKey}/toggle-programmable-feature";
    }

    public function defaultQuery(): array
    {
        return ['cardKey' => $this->cardKey];
    }

    protected function defaultBody(): array
    {
        return ['Enabled' => $this->enabled];
    }
}
