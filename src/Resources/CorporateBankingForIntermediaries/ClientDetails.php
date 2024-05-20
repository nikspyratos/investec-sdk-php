<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Resources\CorporateBankingForIntermediaries;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\ClientDetails\GetClientByAccountNumber;
use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\ClientDetails\SearchClients;
use InvestecSdkPhp\Resources\Resource;
use ReflectionException;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use Saloon\Http\Response;

class ClientDetails extends Resource
{
    /**
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public function getClientDetailsByAccountNumber(string $intermediaryId, string $accountNumber): Response
    {
        return $this->connector->send(new GetClientByAccountNumber($intermediaryId, $accountNumber));
    }

    /**
     * @param  int|null  $page  Must be greater than 0
     * @param  int|null  $pageSize  Min = 10, Max = 100
     *
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     * @throws ReflectionException
     */
    public function clientDashboardSearch(string $intermediaryId, string $searchKeyword, ?int $page, ?int $pageSize): Response
    {
        return $this->connector->send(new SearchClients($intermediaryId, $searchKeyword, $page, $pageSize));
    }
}
