<?php

declare(strict_types=1);

namespace InvestecSdkPhp\DataTransferObjects\PrivateBanking\TransferMultiple;

use DragonCode\SimpleDataTransferObject\DataTransferObject;

class TransferAccountInstance extends DataTransferObject
{
    public string $beneficiaryAccountId;

    public int $amount;

    public string $myReference;

    public string $theirReference;
}
