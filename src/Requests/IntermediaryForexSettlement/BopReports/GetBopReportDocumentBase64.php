<?php

namespace InvestecSdkPhp\Requests\IntermediaryForexSettlement\BopReports;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Retrieves the base64 encoded content of the supporting document identified by the document handle
 */
class GetBopReportDocumentBase64 extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/za/ifi/v1/forex/bop-reports/{$this->transactionReference}/documents/{$this->documentHandle}";
	}


	/**
	 * @param string $transactionReference
	 * @param string $documentHandle
	 */
	public function __construct(
		protected string $transactionReference,
		protected string $documentHandle,
	) {
	}
}
