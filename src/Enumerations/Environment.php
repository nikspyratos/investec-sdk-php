<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Enumerations;

enum Environment: string
{
    case SANDBOX = 'https://openapisandbox.investec.com/';
    case PRODUCTION = 'https://openapi.investec.com/';
}
