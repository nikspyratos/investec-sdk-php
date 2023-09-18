<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Accounts;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Enums\Method;

/**
 * GetTransactionsHistory
 *
 * Returns a list of transactions for the parameterised account number. If no date range is provided
 * the endpoint returns transactions data for the last 7 days.
 */
class GetTransactionsHistory extends IntermediaryRequest
{
    protected Method $method = Method::GET;

    /**
     * @param  null|int  $page Must be greater than 0
     * @param  null|int  $pageSize Min = 10, Max = 100
     * @param  null|string  $startDate dd-MM-yyyy
     * @param  null|string  $endDate dd-MM-yyyy
     * @param  null|string  $sort asc/desc
     */
    public function __construct(
        protected string $intermediaryId,
        protected int $accountNumber,
        protected ?int $page = null,
        protected ?int $pageSize = null,
        protected ?string $startDate = null,
        protected ?string $endDate = null,
        protected ?string $sort = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/za/ifi/v1/accounts/{$this->accountNumber}/transactions";
    }

    public function defaultQuery(): array
    {
        return array_filter([
            'page' => $this->page,
            'page-size' => $this->pageSize,
            'start-date' => $this->startDate,
            'end-date' => $this->endDate,
            'sort' => $this->sort,
        ]);
    }
}
