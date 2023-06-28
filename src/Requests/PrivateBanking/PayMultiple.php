<?php

namespace InvestecSdkPhp\Requests\PrivateBanking;

use InvestecSdkPhp\DataTransferObjects\PrivateBanking\PayMultiple\PayMultipleDto;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class PayMultiple extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $accountIdentifier,
        protected PayMultipleDto $payMultipleDto
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/za/pb/v1/accounts/'.$this->accountIdentifier.'/paymultiple';
    }

    protected function defaultBody(): array
    {
        $payAccountInstances = [];
        foreach ($this->payMultipleDto->accountInstances as $accountInstance) {
            $payAccountInstances[] = [
                'beneficiaryId' => $accountInstance->beneficiaryId,
                'amount' => $accountInstance->amount,
                'myReference' => $accountInstance->myReference,
                'theirReference' => $accountInstance->theirReference,
            ];
        }

        return [
            'paymentList' => $payAccountInstances,
        ];
    }
}
