<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\IntermediaryForexSettlement\BopReports;

use InvestecSdkPhp\Enumerations\BopReportType;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Retrieves all BOP reports for the specified list type
 */
class GetBopReportsByType extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected BopReportType $type,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/za/ifi/v1/forex/bop-reports';
    }

    public function defaultQuery(): array
    {
        return array_filter(['type' => $this->type->value]);
    }
}
