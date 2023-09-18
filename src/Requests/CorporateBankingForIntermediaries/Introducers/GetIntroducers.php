<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\Introducers;

use InvestecSdkPhp\Requests\CorporateBankingForIntermediaries\IntermediaryRequest;
use Saloon\Enums\Method;

/**
 * GetIntroducers
 *
 * Returns a list of introducers.
 */
class GetIntroducers extends IntermediaryRequest
{
    protected Method $method = Method::GET;

    /**
     * @param  null|int  $page Must be greater than 0
     * @param  null|int  $pageSize Min = 10, Max = 100
     * @param  null|string  $filter Search filter keyword
     */
    public function __construct(
        protected string $intermediaryId,
        protected ?int $page = null,
        protected ?int $pageSize = null,
        protected ?string $filter = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/za/ifi/v1/introducers';
    }

    public function defaultQuery(): array
    {
        return array_filter(['page' => $this->page, 'page-size' => $this->pageSize, 'filter' => $this->filter]);
    }
}
