<?php

namespace InvestecSdkPhp\Connectors;

use InvestecSdkPhp\Environment;
use InvestecSdkPhp\Requests\OAuth2\GetAccessTokenRequest;
use InvestecSdkPhp\Resources\PrivateBankingResource;
use Saloon\Contracts\OAuthAuthenticator;
use Saloon\Contracts\Response;
use Saloon\Exceptions\InvalidStateException;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Traits\OAuth2\AuthorizationCodeGrant;

class InvestecOAuthConnector extends Connector
{
    use AuthorizationCodeGrant {
        getAuthorizationUrl as grantGetAuthorizationUrl;
    }

    private string $baseUrl;

    public function __construct(string $clientId, string $clientSecret, Environment $environment = Environment::PRODUCTION)
    {
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
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    protected function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make()
            ->setDefaultScopes(['accounts', 'transactions'])
            ->setAuthorizeEndpoint('/identity/v2/oauth2/authorize')
            ->setTokenEndpoint('/identity/v2/oauth2/token');
    }

    public function getAuthorizationUrl(string $redirectUri, array $scopes = [], string $state = null, string $scopeSeparator = ' ', array $additionalQueryParameters = []): string
    {
        $this->oauthConfig()->setRedirectUri($redirectUri);

        return $this->grantGetAuthorizationUrl($scopes, $state, $scopeSeparator, $additionalQueryParameters);
    }

    public function getAccessToken(
        string $redirectUri,
        string $code,
        string $state = null,
        string $expectedState = null,
        bool $returnResponse = false,
        ?callable $requestModifier = null
    ): OAuthAuthenticator|Response {
        $this->oauthConfig()->setRedirectUri($redirectUri);

        $this->oauthConfig()->validate();

        if (! empty($state) && ! empty($expectedState) && $state !== $expectedState) {
            throw new InvalidStateException;
        }

        $request = new GetAccessTokenRequest($code, $this->oauthConfig());

        $request = $this->oauthConfig()->invokeRequestModifier($request);

        if (is_callable($requestModifier)) {
            $requestModifier($request);
        }

        $response = $this->send($request);

        if ($returnResponse === true) {
            return $response;
        }

        $response->throw();

        return $this->createOAuthAuthenticatorFromResponse($response);
    }

    public function privateBanking(OAuthAuthenticator $authenticator): PrivateBankingResource
    {
        return new PrivateBankingResource($this, $authenticator);
    }
}
