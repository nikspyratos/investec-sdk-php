<?php

namespace InvestecSdkPhp\Requests\CorporateBanking;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetAccountTransactionsRequest
 *
 * Obtain a specified account's transactions.
 */
class GetAccountTransactionsRequest extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/za/bb/v1/accounts/{$this->accountId}/transactions?fromDate=:fromDate&toDate=:toDate&page=1";
	}


	/**
	 * @param string $accountId AccountId Id
	 * @param string $fromDate Refers to the date range filter's start date. Will default to today's date, minus 180 days, if not specified.
	 * @param string $toDate Refers to the date range filter's end date. Will default to today's date if not specified.
	 * @param string $page Refers to the page number.
	 */
	public function __construct(
		protected string $accountId,
		protected string $fromDate,
		protected string $toDate,
		protected string $page,
	) {
	}


	public function defaultQuery(): array
	{
		return ['fromDate' => $this->fromDate, 'toDate' => $this->toDate, 'page' => $this->page];
	}
}
