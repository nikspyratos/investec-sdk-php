<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Resources;

use InvestecSdkPhp\DataTransferObjects\CardCode\ExecuteFunctionCodeDto;
use InvestecSdkPhp\Requests\CardCode\ExecuteFunctionCodeRequest;
use InvestecSdkPhp\Requests\CardCode\GetCardsRequest;
use InvestecSdkPhp\Requests\CardCode\GetCountriesRequest;
use InvestecSdkPhp\Requests\CardCode\GetCurrenciesRequest;
use InvestecSdkPhp\Requests\CardCode\GetFunctionCodeRequest;
use InvestecSdkPhp\Requests\CardCode\GetFunctionEnvironmentVariablesRequest;
use InvestecSdkPhp\Requests\CardCode\GetFunctionExecutionsRequest;
use InvestecSdkPhp\Requests\CardCode\GetMerchantsRequest;
use InvestecSdkPhp\Requests\CardCode\GetPublishedCodeRequest;
use InvestecSdkPhp\Requests\CardCode\PublishFunctionCodeRequest;
use InvestecSdkPhp\Requests\CardCode\ToggleProgrammableCardEnabledRequest;
use InvestecSdkPhp\Requests\CardCode\UpdateFunctionCodeRequest;
use InvestecSdkPhp\Requests\CardCode\UpdateFunctionEnvironmentVariablesRequest;
use Saloon\Contracts\Connector;
use Saloon\Contracts\OAuthAuthenticator;
use Saloon\Http\Response;

class CardCodeResource extends Resource
{
    public function __construct(Connector $connector, OAuthAuthenticator $authenticator)
    {
        parent::__construct($connector);
        $this->connector->authenticate($authenticator);
    }

    public function getCards(): Response
    {
        return $this->connector->send(new GetCardsRequest);
    }

    public function getSavedFunctionCode(string $cardKey): Response
    {
        return $this->connector->send(new GetFunctionCodeRequest($cardKey));

    }

    public function getPublishedFunctionCode(string $cardKey): Response
    {
        return $this->connector->send(new GetPublishedCodeRequest($cardKey));

    }

    public function getCodeExecutions(string $cardKey): Response
    {
        return $this->connector->send(new GetFunctionExecutionsRequest($cardKey));

    }

    public function getEnvironmentVariables(string $cardKey): Response
    {
        return $this->connector->send(new GetFunctionEnvironmentVariablesRequest($cardKey));

    }

    public function getCountries(): Response
    {
        return $this->connector->send(new GetCountriesRequest);

    }

    public function getCurrencies(): Response
    {
        return $this->connector->send(new GetCurrenciesRequest);

    }

    public function getMerchants(): Response
    {
        return $this->connector->send(new GetMerchantsRequest);

    }

    public function updateFunctionCode(string $cardKey, string $code): Response
    {
        return $this->connector->send(new UpdateFunctionCodeRequest($cardKey, $code));

    }

    public function publishSavedCode(string $cardKey, string $codeId): Response
    {
        return $this->connector->send(new PublishFunctionCodeRequest($cardKey, $codeId));

    }

    public function executeSimulatedFunctionCode(string $cardKey, ExecuteFunctionCodeDto $executeFunctionCodeDto): Response
    {
        return $this->connector->send(new ExecuteFunctionCodeRequest($cardKey, $executeFunctionCodeDto));

    }

    public function replaceEnvironmentVariables(string $cardKey): Response
    {
        return $this->connector->send(new UpdateFunctionEnvironmentVariablesRequest($cardKey));

    }

    public function toggleProgrammableCardEnabled(string $cardKey): Response
    {
        return $this->connector->send(new ToggleProgrammableCardEnabledRequest($cardKey));

    }
}
