<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Resources;

use Saloon\Contracts\Connector;

abstract class Resource
{
    public function __construct(protected Connector $connector)
    {
    }
}
