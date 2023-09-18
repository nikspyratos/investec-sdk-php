<?php

namespace InvestecSdkPhp\Requests\IntermediaryForexSettlement\BopReports;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Retrieves the collection of supporting documents required and attached to the BOP report
 */
class GetBopReportDocuments extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/za/ifi/v1/forex/bop-reports/{$this->transactionReference}/documents";
	}


	/**
	 * @param string $transactionReference
	 */
	public function __construct(
		protected string $transactionReference,
	) {
	}
}
