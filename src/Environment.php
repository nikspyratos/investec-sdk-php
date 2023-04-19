<?php

namespace InvestecSdkPhp;

enum Environment: string
{
    case SANDBOX = 'https://openapisandbox.investec.com/';
    case PRODUCTION = 'https://openapi.investec.com/';
}
