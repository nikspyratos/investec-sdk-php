<?php

declare(strict_types=1);

namespace InvestecSdkPhp\Requests\OAuth2;

use Saloon\Http\OAuth2\GetAccessTokenRequest as BaseGetAccessTokenRequest;

class GetAccessTokenRequest extends BaseGetAccessTokenRequest
{
    public function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Basic ' . base64_encode($this->oauthConfig->getClientId() . ':' . $this->oauthConfig->getClientSecret()),
        ];
    }

    public function defaultBody(): array
    {
        //NOTE: At the time of writing, this parameter order is very important. The request will 401 if anything changes.
        return [
            'code' => $this->code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->oauthConfig->getRedirectUri(),
        ];
    }
}
