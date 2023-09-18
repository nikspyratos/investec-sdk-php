<?php

namespace InvestecSdkPhp\Resources\IntermediaryForexSettlement;

use InvestecSdkPhp\Requests\IntermediaryForexSettlement\Forex\GetAccountForexBalances;
use InvestecSdkPhp\Resources\Resource;
use Saloon\Contracts\Response;

class Forex extends Resource
{
    /**
     * @param string $accountNo
     * @return Response
     */
	public function getAccountForexBalances(string $accountNo): Response
	{
		return $this->connector->send(new GetAccountForexBalances($accountNo));
	}
}
