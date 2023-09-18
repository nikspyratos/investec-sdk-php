<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Accounts;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Enums\Method;

/**
 * GetPaymentAccountsByIntermediary
 *
 * Returns accounts for the parameterised account type.
 */
class GetAccountsByType extends IntermediaryRequest
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $accountType Must be 'beneficiary-payment', 'ad-hoc-payment', 'scheduled-payment' or 'interest-instruction'
     * @param  null|string  $keyword Search filter keyword
     * @param  null|string  $categoryId Category-id filter key
     * @param  null|int  $page Must be greater than 0
     * @param  null|int  $pageSize Min = 10, Max = 100
     */
    public function __construct(
        protected string $intermediaryId,
        protected string $accountType,
        protected ?string $keyword = null,
        protected ?string $categoryId = null,
        protected ?int $page = null,
        protected ?int $pageSize = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/za/ifi/v1/accounts/{$this->accountType}";
    }

    public function defaultQuery(): array
    {
        return array_filter([
            'keyword' => $this->keyword,
            'category-id' => $this->categoryId,
            'page' => $this->page,
            'page-size' => $this->pageSize,
        ]);
    }
}
