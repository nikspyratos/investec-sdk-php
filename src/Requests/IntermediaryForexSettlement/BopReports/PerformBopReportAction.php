<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\IntermediaryForexSettlement\BopReports;

use InvestecSdkPhp\Enumerations\BopReportAction;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Perfoms the specified action against the BOP report identified by the transaction reference
 */
class PerformBopReportAction extends Request
{
    protected Method $method = Method::PATCH;

    public function __construct(
        protected string $transactionReference,
        protected BopReportAction $bopReportAction,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/za/ifi/v1/forex/bop-reports/{$this->transactionReference}:{$this->bopReportAction->value}";
    }
}
