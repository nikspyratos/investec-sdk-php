<?php

namespace InvestecSdkPhp\Requests\IntermediaryForexSettlement\BopReports;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Retrieves BOP report details for the specified transaction reference
 */
class GetBopReportsByTransactionReference extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/za/ifi/v1/forex/bop-reports/{$this->transactionReference}";
	}


	/**
	 * @param string $transactionReference
	 */
	public function __construct(
		protected string $transactionReference,

	) {
	}
}
