<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\ClientDetails;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Enums\Method;

/**
 * ClientDashboardSearch
 *
 * Returns a list of clients for the parameterised search keyword.
 */
class SearchClients extends IntermediaryRequest
{
    protected Method $method = Method::GET;

    /**
     * @param  null|int  $page Must be greater than 0
     * @param  null|int  $pageSize Min = 10, Max = 100
     */
    public function __construct(
        protected string $intermediaryId,
        protected string $searchKeyword,
        protected ?int $page = null,
        protected ?int $pageSize = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/za/ifi/v1/clients/client-dashboard/{$this->searchKeyword}";
    }

    public function defaultQuery(): array
    {
        return array_filter(['page' => $this->page, 'page-size' => $this->pageSize]);
    }
}
