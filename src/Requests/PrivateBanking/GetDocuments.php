<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\PrivateBanking;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetDocuments extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $accountId,
        protected ?string $fromDate = null,
        protected ?string $toDate = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        $endpoint = sprintf(
            '/za/pb/v1/accounts/%s/documents',
            $this->accountId
        );
        if ($this->fromDate && ! $this->toDate) {
            $endpoint = sprintf(
                '%s?fromDate=%s',
                $endpoint,
                $this->fromDate,
            );
        } elseif (! $this->fromDate && $this->toDate) {
            $endpoint = sprintf(
                '%s?toDate=%s',
                $endpoint,
                $this->toDate,
            );
        } elseif ($this->fromDate && $this->toDate) {
            $endpoint = sprintf(
                '%s?fromDate=%s&toDate=%s',
                $endpoint,
                $this->fromDate,
                $this->toDate,
            );
        }

        return $endpoint;
    }
}
