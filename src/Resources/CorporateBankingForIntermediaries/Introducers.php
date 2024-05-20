<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Resources\CorporateBankingForIntermediaries;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Introducers\CreateIntroducer;
use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Introducers\DeleteIntroducer;
use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Introducers\GetIntroducers;
use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Introducers\GetIntroducersSummary;
use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Introducers\UpdateIntroducer;
use InvestecSdkPhp\Resources\Resource;
use ReflectionException;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use Saloon\Http\Response;

class Introducers extends Resource
{
    /**
     * @param  int|null  $page  Must be greater than 0
     * @param  int|null  $pageSize  Min = 10, Max = 100
     * @param  string|null  $filter  Search filter keyword
     * @param  string|null  $sort  Must be 'asc' or 'desc'
     *
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     * @throws ReflectionException
     */
    public function getIntroducersSummary(string $intermediaryId, ?int $page, ?int $pageSize, ?string $filter, ?string $sort): Response
    {
        return $this->connector->send(new GetIntroducersSummary($intermediaryId, $page, $pageSize, $filter, $sort));
    }

    /**
     * @param  int|null  $page  Must be greater than 0
     * @param  int|null  $pageSize  Min = 10, Max = 100
     * @param  string|null  $filter  Search filter keyword
     *
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     * @throws ReflectionException
     */
    public function getIntroducers(string $intermediaryId, ?int $page, ?int $pageSize, ?string $filter): Response
    {
        return $this->connector->send(new GetIntroducers($intermediaryId, $page, $pageSize, $filter));
    }

    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws PendingRequestException
     */
    public function amendIntroducer(string $intermediaryId): Response
    {
        return $this->connector->send(new UpdateIntroducer($intermediaryId));
    }

    /**
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public function addIntroducer(string $intermediaryId): Response
    {
        return $this->connector->send(new CreateIntroducer($intermediaryId));
    }

    /**
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public function deleteIntroducer(string $intermediaryId, string $introducerId): Response
    {
        return $this->connector->send(new DeleteIntroducer($intermediaryId, $introducerId));
    }
}
