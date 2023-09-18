<?php

namespace InvestecSdkPhp\Resources;

use InvestecSdkPhp\Resources\IntermediaryForexSettlement\BopReports;
use InvestecSdkPhp\Resources\IntermediaryForexSettlement\Forex;
use Saloon\Contracts\OAuthAuthenticator;
use Saloon\Http\Connector;

class IntermediaryForexSettlementResource extends Resource
{
    private BopReports $bopReports;
    private Forex $forex;

    public function __construct(Connector $connector, OAuthAuthenticator $authenticator)
    {
        parent::__construct($connector);
        $this->connector->authenticate($authenticator);
        $this->bopReports = new BopReports($connector);
        $this->forex = new Forex($connector);
    }

    public function bopReports(): BopReports
    {
        return $this->bopReports;
    }

    public function forex(): Forex
    {
        return $this->forex;
    }

}
