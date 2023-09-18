<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Resources\IntermediaryForexSettlement;

use InvestecSdkPhp\Enumerations\BopReportAction;
use InvestecSdkPhp\Enumerations\BopReportType;
use InvestecSdkPhp\Requests\IntermediaryForexSettlement\BopReports\GetBopReportDocumentBase64;
use InvestecSdkPhp\Requests\IntermediaryForexSettlement\BopReports\GetBopReportDocuments;
use InvestecSdkPhp\Requests\IntermediaryForexSettlement\BopReports\GetBopReportsByTransactionReference;
use InvestecSdkPhp\Requests\IntermediaryForexSettlement\BopReports\GetBopReportsByType;
use InvestecSdkPhp\Requests\IntermediaryForexSettlement\BopReports\PerformBopReportAction;
use InvestecSdkPhp\Resources\Resource;
use Saloon\Contracts\Response;

class BopReports extends Resource
{
    public function getBopReportsByType(BopReportType $type): Response
    {
        return $this->connector->send(new GetBopReportsByType($type));
    }

    public function getBopReportsByTransactionReference(string $transactionReference): Response
    {
        return $this->connector->send(new GetBopReportsByTransactionReference($transactionReference));
    }

    public function getBopReportDocuments(
        string $transactionReference,
    ): Response {
        return $this->connector->send(new GetBopReportDocuments($transactionReference));
    }

    public function getBopReportDocumentBase64(string $transactionReference, string $documentHandle): Response
    {
        return $this->connector->send(new GetBopReportDocumentBase64($transactionReference, $documentHandle));
    }

    public function performBopReportAction(string $transactionReference, BopReportAction $action): Response
    {
        return $this->connector->send(new PerformBopReportAction($transactionReference, $action));
    }

    //TODO: updateBopReport, validateBopReport, upload document contents

}
