<?php

declare(strict_types=1);

namespace InvestecSdkPhp\DataTransferObjects\PrivateBanking\PayMultiple;

use DragonCode\SimpleDataTransferObject\DataTransferObject;

class PayAccountInstance extends DataTransferObject
{
    public string $beneficiaryId;

    public int $amount;

    public string $myReference;

    public string $theirReference;
}
