<?php

declare(strict_types=1);

use InvestecSdkPhp\Connectors\InvestecConnector;
use InvestecSdkPhp\Connectors\InvestecOAuthConnector;
use InvestecSdkPhp\Enumerations\Environment;
use Saloon\Contracts\OAuthAuthenticator;

it('can get a personal use access token', function () {
    $connector = new InvestecConnector(
        $_ENV['INVESTEC_OPENAPI_CLIENTID'],
        $_ENV['INVESTEC_OPENAPI_SECRET'],
        $_ENV['INVESTEC_OPENAPI_API_KEY'],
        Environment::SANDBOX
    );

    $authenticator = $connector->getAccessToken();

    expect($authenticator)
        ->toBeInstanceOf(OAuthAuthenticator::class)
        ->and($authenticator->getAccessToken())
        ->toBeTruthy();
})
    ->group('auth-personal');

it('generates an OAuth redirect URL', function () {
    $redirectUri = 'https://www.example.com';
    $connector = new InvestecOAuthConnector(
        $_ENV['INVESTEC_OPENAPI_CLIENTID'],
        $_ENV['INVESTEC_OPENAPI_SECRET'],
        Environment::SANDBOX
    );

    $authUrl = $connector->getAuthorizationUrl($redirectUri);

    expect($authUrl)
        ->toBeTruthy()
        ->toContain(
            'scope=accounts',
            'client_id=' . $_ENV['INVESTEC_OPENAPI_CLIENTID'],
            'redirect_uri=' . urlencode($redirectUri),
            'response_type=code'
        );
})
    ->group('auth-business');

it('generates a 3rd party access token', function () {
    //TODO
})
    ->skip('Sandbox credentials for 3-legged OAuth missing')
    ->group('auth-business');

it('can refresh an access token', function () {
    //TODO
})
    ->skip('Sandbox credentials for 3-legged OAuth missing')
    ->group('auth-business');
