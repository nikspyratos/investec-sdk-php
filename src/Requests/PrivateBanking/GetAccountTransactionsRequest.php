<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\PrivateBanking;

use Carbon\Carbon;
use InvestecSdkPhp\Enumerations\TransactionType;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetAccountTransactionsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $accountIdentifier,
        protected ?string $fromDate = null,
        protected ?string $toDate = null,
        protected ?TransactionType $transactionType = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        $url = sprintf(
            '/za/pb/v1/accounts/%s/transactions?fromDate=%s&toDate=%s',
            $this->accountIdentifier,
            $this->fromDate ?? Carbon::today()->subDay()->format('Y-m-d'),
            $this->toDate ?? Carbon::today()->format('Y-m-d'),
        );
        if ($this->transactionType) {
            $url .= '&transactionType=' . $this->transactionType->value;
        }

        return $url;
    }
}
