<?php

namespace InvestecSdkPhp\Connectors;

use InvalidArgumentException;
use InvestecSdkPhp\Enumerations\Environment;
use InvestecSdkPhp\Requests\OAuth2\GetAccessTokenRequest;
use InvestecSdkPhp\Requests\OAuth2\GetRefreshTokenRequest;
use InvestecSdkPhp\Resources\PrivateBankingResource;
use ReflectionException;
use Saloon\Contracts\OAuthAuthenticator;
use Saloon\Contracts\Request;
use Saloon\Contracts\Response;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\InvalidStateException;
use Saloon\Exceptions\OAuthConfigValidationException;
use Saloon\Exceptions\PendingRequestException;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Traits\OAuth2\AuthorizationCodeGrant;

class InvestecOAuthConnector extends Connector
{
    use AuthorizationCodeGrant {
        getAuthorizationUrl as grantGetAuthorizationUrl;
    }

    private readonly string $baseUrl;

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
            ->setDefaultScopes(['accounts', 'balances', 'transactions'])
            ->setAuthorizeEndpoint('/identity/v2/oauth2/authorize')
            ->setTokenEndpoint('/identity/v2/oauth2/token');
    }

    public function getAuthorizationUrl(string $redirectUri, array $scopes = ['accounts'], string $state = null, string $scopeSeparator = ' ', array $additionalQueryParameters = []): string
    {
        $this->oauthConfig()->setRedirectUri($redirectUri);

        return $this->grantGetAuthorizationUrl($scopes, $state, $scopeSeparator, $additionalQueryParameters);
    }

    /**
     * Get the access token.
     * Override of AuthorizationCodeGrant trait method, for Investec API.
     *
     * @template TRequest of Request
     *
     * @param  callable(TRequest): (void)|null  $requestModifier
     *
     * @throws InvalidResponseClassException
     * @throws InvalidStateException
     * @throws OAuthConfigValidationException
     * @throws PendingRequestException
     * @throws ReflectionException
     */
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

    /**
     * Refresh the access token.
     * Override of AuthorizationCodeGrant trait method, for Investec API.
     *
     * @template TRequest of Request
     *
     * @param  callable(TRequest): (void)|null  $requestModifier
     *
     * @throws InvalidResponseClassException
     * @throws OAuthConfigValidationException
     * @throws PendingRequestException
     * @throws ReflectionException
     */
    public function refreshAccessToken(
        string|OAuthAuthenticator $refreshToken,
        bool $returnResponse = false,
        ?callable $requestModifier = null
    ): OAuthAuthenticator|Response {
        $this->oauthConfig()->validate();

        if ($refreshToken instanceof OAuthAuthenticator) {
            if ($refreshToken->isNotRefreshable()) {
                throw new InvalidArgumentException('The provided OAuthAuthenticator does not contain a refresh token.');
            }

            $refreshToken = $refreshToken->getRefreshToken();
        }

        $request = new GetRefreshTokenRequest($this->oauthConfig(), $refreshToken);

        $request = $this->oauthConfig()->invokeRequestModifier($request);

        if (is_callable($requestModifier)) {
            $requestModifier($request);
        }

        $response = $this->send($request);

        if ($returnResponse === true) {
            return $response;
        }

        $response->throw();

        return $this->createOAuthAuthenticatorFromResponse($response, $refreshToken);
    }

    public function privateBanking(OAuthAuthenticator $authenticator): PrivateBankingResource
    {
        return new PrivateBankingResource($this, $authenticator);
    }
}
