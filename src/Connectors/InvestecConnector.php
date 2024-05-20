<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Connectors;

use InvestecSdkPhp\Enumerations\Environment;
use InvestecSdkPhp\Resources\CardCodeResource;
use InvestecSdkPhp\Resources\CorporateBankingResource;
use InvestecSdkPhp\Resources\IntermediaryForexSettlementResource;
use InvestecSdkPhp\Resources\PrivateBankingResource;
use Saloon\Contracts\OAuthAuthenticator;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\OAuth2\GetClientCredentialsTokenRequest;
use Saloon\Traits\OAuth2\ClientCredentialsGrant;

class InvestecConnector extends Connector
{
    use ClientCredentialsGrant {
        getAccessToken as traitGetAccessToken;
    }

    private readonly string $baseUrl;

    public function __construct(private readonly string $clientId, private readonly string $clientSecret, private readonly string $apiKey, Environment $environment = Environment::PRODUCTION)
    {

        $this->baseUrl = $environment->value;
        $this->oauthConfig()->setClientId($clientId);
        $this->oauthConfig()->setClientSecret($clientSecret);
    }

    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getAccessToken($scopes = ['accounts']): OAuthAuthenticator
    {
        return $this->traitGetAccessToken(
            $scopes,
            ' ',
            false,
            function (
                GetClientCredentialsTokenRequest $request
            ) {
                $request->authenticate(new TokenAuthenticator(base64_encode($this->clientId . ':' . $this->clientSecret), 'Basic'))
                    ->headers()
                    ->add('x-api-key', $this->apiKey);
            }
        );
    }

    public function privateBanking(OAuthAuthenticator $authenticator): PrivateBankingResource
    {
        return new PrivateBankingResource($this, $authenticator);
    }

    /**
     * @experimental
     */
    public function cardCode(OAuthAuthenticator $authenticator): CardCodeResource
    {
        return new CardCodeResource($this, $authenticator);
    }

    public function corporateBanking(OAuthAuthenticator $authenticator): CorporateBankingResource
    {
        return new CorporateBankingResource($this, $authenticator);
    }

    /**
     * @experimental
     */
    public function intermediaryForexSettlement(OAuthAuthenticator $authenticator): IntermediaryForexSettlementResource
    {
        return new IntermediaryForexSettlementResource($this, $authenticator);
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
        ];
    }

    protected function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make()
            ->setDefaultScopes(['accounts'])
            ->setTokenEndpoint('/identity/v2/oauth2/token');
    }
}
