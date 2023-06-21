<?php

namespace InvestecSdkPhp\DataTransferObjects\PrivateBanking\TransferMultiple;

use DragonCode\SimpleDataTransferObject\DataTransferObject;

class TransferMultipleDto extends DataTransferObject
{
    /** @var array TransferAccountInstance[] */
    public array $accountInstances;

    protected function castAccountInstances(array $accountInstances): array
    {
        return array_map(static function (array $project) {
            return TransferAccountInstance::make([
                'beneficiaryAccountId' => $project['beneficiaryAccountId'],
                'amount' => $project['amount'],
                'myReference' => $project['myReference'],
                'theirReference' => $project['theirReference'],
            ]);
        }, $accountInstances);
    }
}
