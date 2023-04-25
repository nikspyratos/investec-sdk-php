<?php

namespace InvestecSdkPhp\Requests\OAuth2;

use Saloon\Http\OAuth2\GetAccessTokenRequest as BaseGetAccessTokenRequest;

class GetAccessTokenRequest extends BaseGetAccessTokenRequest
{
    public function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Basic'.base64_encode($this->oauthConfig->getClientId().':'.$this->oauthConfig->getClientSecret()),
        ];
    }

    public function defaultBody(): array
    {
        return [
            'grant_type' => 'authorization_code',
            'code' => $this->code,
            'redirect_uri' => $this->oauthConfig->getRedirectUri(),
        ];
    }
}
