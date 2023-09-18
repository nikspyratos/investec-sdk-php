<?php

declare(strict_types=1);

use InvestecSdkPhp\Connectors\InvestecConnector;
use InvestecSdkPhp\Enumerations\Environment;

$connector = null;
$authenticator = null;

beforeAll(function () use (&$connector, &$authenticator) {
    $connector = new InvestecConnector(
        $_ENV['INVESTEC_OPENAPI_CLIENTID'],
        $_ENV['INVESTEC_OPENAPI_SECRET'],
        $_ENV['INVESTEC_OPENAPI_API_KEY'],
        Environment::SANDBOX
    );

    $authenticator = $connector->getAccessToken();
});

beforeEach(function () use (&$connector, &$authenticator) {
    $this->cardCodeClient = $connector->cardCode($authenticator);
});
