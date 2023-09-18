<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\PrivateBanking;

use Carbon\Carbon;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetDocuments extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $accountId,
        protected ?string $fromDate = null,
        protected ?string $toDate = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return sprintf(
            '/za/pb/v1/accounts/%s/documents?fromDate=%s&toDate=%s',
            $this->accountId,
            $this->fromDate ?? Carbon::today()->subMonth()->format('Y-m-d'),
            $this->toDate ?? Carbon::today()->format('Y-m-d'),
        );
    }
}
