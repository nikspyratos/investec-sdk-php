<?php

namespace InvestecSdkPhp\Resources\IntermediaryForexSettlement;

use InvestecSdkPhp\Enumerations\BopReportAction;
use InvestecSdkPhp\Enumerations\BopReportType;
use InvestecSdkPhp\Requests\IntermediaryForexSettlement\BopReports\PerformBopReportAction;
use InvestecSdkPhp\Requests\IntermediaryForexSettlement\BopReports\GetBopReportsByType;
use InvestecSdkPhp\Requests\IntermediaryForexSettlement\BopReports\GetBopReportsByTransactionReference;
use InvestecSdkPhp\Requests\IntermediaryForexSettlement\BopReports\GetBopReportDocumentBase64;
use InvestecSdkPhp\Requests\IntermediaryForexSettlement\BopReports\GetBopReportDocuments;
use InvestecSdkPhp\Resources\Resource;
use Saloon\Contracts\Response;

class BopReports extends Resource
{
    /**
     * @param BopReportType $type
     * @return Response
     */
	public function getBopReportsByType(BopReportType $type): Response
	{
		return $this->connector->send(new GetBopReportsByType($type));
	}

    /**
     * @param string $transactionReference
     * @return Response
     */
	public function getBopReportsByTransactionReference(string $transactionReference): Response
	{
		return $this->connector->send(new GetBopReportsByTransactionReference($transactionReference));
	}

    /**
     * @param string $transactionReference
     * @return Response
     */
	public function getBopReportDocuments(
		string $transactionReference,
	): Response
	{
		return $this->connector->send(new GetBopReportDocuments($transactionReference));
	}

    /**
     * @param string $transactionReference
     * @param string $documentHandle
     * @return Response
     */
	public function getBopReportDocumentBase64(string $transactionReference, string $documentHandle,): Response
	{
		return $this->connector->send(new GetBopReportDocumentBase64($transactionReference, $documentHandle));
	}

    /**
     * @param string $transactionReference
     * @param BopReportAction $action
     * @return Response
     */
	public function performBopReportAction(string $transactionReference, BopReportAction $action,): Response
	{
		return $this->connector->send(new PerformBopReportAction($transactionReference, $action));
	}

    //TODO: updateBopReport, validateBopReport, upload document contents

}
