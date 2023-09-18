<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Banks;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Enums\Method;

/**
 * GetBanks
 *
 * Gets list of banks.
 */
class GetBanks extends IntermediaryRequest
{
    protected Method $method = Method::GET;

    /**
     * @param  null|string  $sort Can be either asc or desc
     * @param  null|int  $page Must be greater than 0
     * @param  null|int  $pageSize Min = 10, Max = 100
     */
    public function __construct(
        protected string $intermediaryId,
        protected ?string $sort = null,
        protected ?int $page = null,
        protected ?int $pageSize = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/za/ifi/v1/banks';
    }

    public function defaultQuery(): array
    {
        return array_filter(['sort' => $this->sort, 'page' => $this->page, 'page-size' => $this->pageSize]);
    }
}
