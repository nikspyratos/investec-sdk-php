<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Resources\CorporateBankingForIntermediaries;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Categories\CreateCategory;
use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Categories\DeleteCategory;
use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Categories\GetCategories;
use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Categories\PatchCategory;
use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Categories\SetDefaultCategory;
use InvestecSdkPhp\Resources\Resource;
use ReflectionException;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use Saloon\Http\Response;

class Categories extends Resource
{
    /**
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public function getCategories(string $intermediaryId): Response
    {
        return $this->connector->send(new GetCategories($intermediaryId));
    }

    /**
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public function createCategory(string $intermediaryId): Response
    {
        return $this->connector->send(new CreateCategory($intermediaryId));
    }

    /**
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public function amendCategory(string $intermediaryId): Response
    {
        return $this->connector->send(new PatchCategory($intermediaryId));
    }

    /**
     * @throws ReflectionException
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     */
    public function deleteCategory(string $intermediaryId, string $categoryId): Response
    {
        return $this->connector->send(new DeleteCategory($intermediaryId, $categoryId));
    }

    /**
     * @throws InvalidResponseClassException
     * @throws PendingRequestException
     * @throws ReflectionException
     */
    public function setDefaultCategory(string $intermediaryId, string $categoryId): Response
    {
        return $this->connector->send(new SetDefaultCategory($intermediaryId, $categoryId));
    }
}
