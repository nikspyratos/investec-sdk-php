<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Resources\CorporateBankingForIntermediaries;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Intermediaries\GetIntermediaries;
use InvestecSdkPhp\Resources\Resource;
use ReflectionException;
use Saloon\Contracts\Response;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;

class Intermediaries extends Resource
{
    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws PendingRequestException
     */
    public function getLinkedProfiles(string $intermediaryId): Response
    {
        return $this->connector->send(new GetIntermediaries($intermediaryId));
    }
}
