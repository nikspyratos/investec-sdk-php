<?php

namespace InvestecSdkPhp\Requests\OAuth2;

use Saloon\Http\OAuth2\GetRefreshTokenRequest as BaseGetRefreshTokenRequest;

class GetRefreshTokenRequest extends BaseGetRefreshTokenRequest
{
    public function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Basic '.base64_encode($this->oauthConfig->getClientId().':'.$this->oauthConfig->getClientSecret()),
        ];
    }

    public function defaultBody(): array
    {
        return [
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->refreshToken,
        ];
    }
}
