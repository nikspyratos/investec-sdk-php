<?php

namespace InvestecSdkPhp\Requests\PrivateBanking;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetDocument extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/za/pb/v1/accounts/{$this->accountId}/document/{$this->documentType}/{$this->documentDate}";
    }

    public function __construct(
        protected string $accountId,
        protected string $documentType,
        protected string $documentDate
    ) {
    }
}
