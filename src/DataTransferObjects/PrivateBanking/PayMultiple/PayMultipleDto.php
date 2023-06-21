<?php

namespace InvestecSdkPhp\DataTransferObjects\PrivateBanking\PayMultiple;

use DragonCode\SimpleDataTransferObject\DataTransferObject;
use InvestecSdkPhp\DataTransferObjects\PrivateBanking\TransferMultiple\TransferAccountInstance;

class PayMultipleDto extends DataTransferObject
{
    /** @var array TransferAccountInstance[] */
    public array $accountInstances;

    protected function castAccountInstances(array $accountInstances): array
    {
        return array_map(static fn (array $project) => TransferAccountInstance::make([
            'beneficiaryId' => $project['beneficiaryAccountId'],
            'amount' => $project['amount'],
            'myReference' => $project['myReference'],
            'theirReference' => $project['theirReference'],
        ]), $accountInstances);
    }
}
