<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Accounts;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Enums\Method;

/**
 * GetUnderlyingAccounts
 *
 * Returns a list of client account details for the parameterised account status and intermediaryId.
 */
class GetClientAccounts extends IntermediaryRequest
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $accountStatus Must be 'Open' or 'Closed'
     * @param  null|int  $page Must be greater than 0
     * @param  null|int  $pageSize Min = 10, Max = 100
     */
    public function __construct(
        protected string $intermediaryId,
        protected string $accountStatus,
        protected ?int $page = null,
        protected ?int $pageSize = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/za/ifi/v1/accounts/intermediary/clients/{$this->accountStatus}";
    }

    public function defaultQuery(): array
    {
        return array_filter(['page' => $this->page, 'page-size' => $this->pageSize]);
    }
}
