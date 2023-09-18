<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\IntermediaryForexSettlement\BopReports;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Retrieves the collection of supporting documents required and attached to the BOP report
 */
class GetBopReportDocuments extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $transactionReference,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/za/ifi/v1/forex/bop-reports/{$this->transactionReference}/documents";
    }
}
