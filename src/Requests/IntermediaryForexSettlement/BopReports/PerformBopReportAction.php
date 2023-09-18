<?php

namespace InvestecSdkPhp\Requests\IntermediaryForexSettlement\BopReports;

use InvestecSdkPhp\Enumerations\BopReportAction;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Perfoms the specified action against the BOP report identified by the transaction reference
 */
class PerformBopReportAction extends Request
{

	protected Method $method = Method::PATCH;


	public function resolveEndpoint(): string
	{
		return "/za/ifi/v1/forex/bop-reports/{$this->transactionReference}:{$this->bopReportAction->value}";
	}

    /**
     * @param string $transactionReference
     * @param BopReportAction $bopReportAction
     */
	public function __construct(
		protected string $transactionReference,
		protected BopReportAction $bopReportAction,
	) {
	}
}
