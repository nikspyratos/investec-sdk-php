<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Resources;

use InvestecSdkPhp\Resources\CorporateBankingForIntermediaries\Accounts;
use InvestecSdkPhp\Resources\CorporateBankingForIntermediaries\Banks;
use InvestecSdkPhp\Resources\CorporateBankingForIntermediaries\Categories;
use InvestecSdkPhp\Resources\CorporateBankingForIntermediaries\ClientDetails;
use InvestecSdkPhp\Resources\CorporateBankingForIntermediaries\Intermediaries;
use InvestecSdkPhp\Resources\CorporateBankingForIntermediaries\Introducers;
use Saloon\Contracts\OAuthAuthenticator;
use Saloon\Http\Connector;

/**
 * @experimental Implemented according to spec, but untested. Please contribute fixes and tests if you use this!
 */
class CorporateBankingForIntermediariesResource extends Resource
{
    private Accounts $accounts;
    private Banks $banks;
    private Categories $categories;
    private ClientDetails $clientDetails;
    private Intermediaries $intermediaries;
    private Introducers $introducers;

    public function __construct(Connector $connector, OAuthAuthenticator $authenticator)
    {
        parent::__construct($connector);
        $this->connector->authenticate($authenticator);
        $this->accounts = new Accounts($connector);
        $this->banks = new Banks($connector);
        $this->categories = new Categories($connector);
        $this->clientDetails = new ClientDetails($connector);
        $this->intermediaries = new Intermediaries($connector);
        $this->introducers = new Introducers($connector);
    }

    public function accounts(): Accounts
    {
        return $this->accounts;
    }

    public function banks(): Banks
    {
        return $this->banks;
    }

    public function categories(): Categories
    {
        return $this->categories;
    }

    public function clientDetails(): ClientDetails
    {
        return $this->clientDetails;
    }

    public function intermediaries(): Intermediaries
    {
        return $this->intermediaries;
    }

    public function introducers(): Introducers
    {
        return $this->introducers;
    }
}
