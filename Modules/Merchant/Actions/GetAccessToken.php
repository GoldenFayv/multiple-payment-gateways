<?php

namespace App\Action;

// use App\Enum\GrantType;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use League\OAuth2\Server\AuthorizationServer;
use Modules\Merchant\Enums\Enum\GrantType;

class GetAccessToken
{
    public function handle(array $credentials)
    {
        $grant_type = GrantType::tryFrom($credentials['grant_type']);
        $payload = match ($grant_type) {
            GrantType::PASSWORD => [
                'grant_type'    => 'password',
                'client_id'     => config('passport.client_id'),
                'client_secret' => config('passport.client_secret'),
                'username'      => $credentials['email'],
                'password'      => $credentials['password'],
                'scope'         => '*',
            ],
            GrantType::REFRESH_TOKEN => [
                'grant_type'    => 'refresh_token',
                'refresh_token' => $credentials['refresh_token'],
                'client_id'     => config('passport.client_id'),
                'client_secret' => config('passport.client_secret'),
                'scope'         => '*',
            ],
            default => throw new \InvalidArgumentException("Invalid grant type: {$credentials['grant_type']}"),
        };

        $request = (new ServerRequest('POST', '/oauth/token'))
            ->withParsedBody($payload);

        $response = app(AuthorizationServer::class)
            ->respondToAccessTokenRequest(
                $request,
                new Response()
            );

        return json_decode((string) $response->getBody(), true);
    }
}
