<?php

declare(strict_types=1);

namespace InvestecSdkPhp\DataTransferObjects\PrivateBanking\PayMultiple;

use DragonCode\SimpleDataTransferObject\DataTransferObject;

class PayMultipleDto extends DataTransferObject
{
    /** @var array PayAccountInstance[] */
    public array $accountInstances;

    protected function castAccountInstances(array $accountInstances): array
    {
        return array_map(static fn (array $project) => PayAccountInstance::make([
            'beneficiaryId' => $project['beneficiaryId'],
            'amount' => $project['amount'],
            'myReference' => $project['myReference'],
            'theirReference' => $project['theirReference'],
        ]), $accountInstances);
    }
}
