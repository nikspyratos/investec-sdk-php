<?php

namespace InvestecSdkPhp\Connectors;

use InvestecSdkPhp\Enumerations\Environment;
use InvestecSdkPhp\Resources\PrivateBankingResource;
use Saloon\Contracts\Authenticator;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Http\OAuth2\GetClientCredentialsTokenRequest;
use Saloon\Traits\OAuth2\ClientCredentialsGrant;

class InvestecConnector extends Connector
{
    use ClientCredentialsGrant {
        getAccessToken as traitGetAccessToken;
    }

    private string $clientId;

    private string $clientSecret;

    private string $apiKey;

    private string $baseUrl;

    public function __construct(string $clientId, string $clientSecret, string $apiKey, Environment $environment = Environment::PRODUCTION)
    {

        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->apiKey = $apiKey;
        $this->baseUrl = $environment->value;
        $this->oauthConfig()->setClientId($clientId);
        $this->oauthConfig()->setClientSecret($clientSecret);
    }

    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
        ];
    }

    public function getAccessToken(): Authenticator
    {
        return $this->traitGetAccessToken(
            [],
            '',
            false,
            function (
                GetClientCredentialsTokenRequest $request
            ) {
                $request->withTokenAuth(base64_encode($this->clientId.':'.$this->clientSecret), 'Basic')
                    ->headers()
                    ->add('x-api-key', $this->apiKey);
            }
        );
    }

    protected function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make()
            ->setDefaultScopes(['accounts', 'transactions'])
            ->setTokenEndpoint('/identity/v2/oauth2/token');
    }

    public function privateBanking(Authenticator $authenticator): PrivateBankingResource
    {
        return new PrivateBankingResource($this, $authenticator);
    }
}
