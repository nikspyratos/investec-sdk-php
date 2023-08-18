<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\PrivateBanking;

use InvestecSdkPhp\DataTransferObjects\PrivateBanking\TransferMultiple\TransferMultipleDto;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class TransferMultipleV2Request extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $accountIdentifier,
        protected TransferMultipleDto $transferMultipleDto
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/za/pb/v1/accounts/' . $this->accountIdentifier . '/transfermultiple';
    }

    protected function defaultBody(): array
    {
        $transferAccountInstances = [];
        foreach ($this->transferMultipleDto->accountInstances as $accountInstance) {
            $transferAccountInstances[] = [
                'beneficiaryAccountId' => $accountInstance->beneficiaryAccountId,
                'amount' => $accountInstance->amount,
                'myReference' => $accountInstance->myReference,
                'theirReference' => $accountInstance->theirReference,
            ];
        }

        return [
            'transferList' => $transferAccountInstances,
        ];
    }
}
