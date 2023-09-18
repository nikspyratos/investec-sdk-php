<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Accounts;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Enums\Method;

/**
 * GetAccountsSearch
 *
 * Returns a list of accounts for that contain the parameterised keyword.
 */
class SearchAccounts extends IntermediaryRequest
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $accountStatus 'Open' => OPEN Accounts | 'Closed' => CLOSED Accounts
     * @param  null|int  $page Must be greater than 0
     * @param  null|int  $pageSize Min = 10, Max = 100
     */
    public function __construct(
        protected string $intermediaryId,
        protected string $accountStatus,
        protected string $keyword,
        protected ?int $page = null,
        protected ?int $pageSize = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/za/ifi/v1/accounts/summary/{$this->accountStatus}/search/{$this->keyword}";
    }

    public function defaultQuery(): array
    {
        return array_filter(['page' => $this->page, 'page-size' => $this->pageSize]);
    }
}
