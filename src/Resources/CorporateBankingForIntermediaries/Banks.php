<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Resources\CorporateBankingForIntermediaries;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Banks\GetBanks;
use InvestecSdkPhp\Resource;
use ReflectionException;
use Saloon\Contracts\Response;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;

class Banks extends Resource
{
    /**
     * @param  string|null  $sort Can be either asc or desc
     * @param  int|null  $page Must be greater than 0
     * @param  int|null  $pageSize Min = 10, Max = 100
     *
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public function getBanks(string $intermediaryId, ?string $sort, ?int $page, ?int $pageSize): Response
    {
        return $this->connector->send(new GetBanks($intermediaryId, $sort, $page, $pageSize));
    }
}
