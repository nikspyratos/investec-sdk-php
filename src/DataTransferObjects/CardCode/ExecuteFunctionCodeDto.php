<?php

declare(strict_types=1);

namespace InvestecSdkPhp\DataTransferObjects\CardCode;

use DragonCode\SimpleDataTransferObject\DataTransferObject;

class ExecuteFunctionCodeDto extends DataTransferObject
{
    public string $simulationCode;

    public int $centsAmount;

    public string $merchantCode;

    public string $merchantName;

    public string $merchantCity;

    public string $countryCode;
}
