<?php

namespace Modules\PaymentCore\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

abstract class BaseGatewayClient
{
    abstract protected function baseUrl(): string;

    abstract protected function headers(): array;

    protected function timeout(): int
    {
        return 30;
    }

    protected function http(): PendingRequest
    {
        return Http::baseUrl($this->baseUrl())
            ->acceptJson()
            ->asJson()
            ->withHeaders($this->headers())
            ->timeout($this->timeout());
    }

    protected function get(string $uri, array $query = []): array
    {
        $response = $this->http()->get($uri, $query);

        return $this->handleResponse($response);
    }

    protected function post(string $uri, array $payload = []): array
    {
        $response = $this->http()->post($uri, $payload);

        return $this->handleResponse($response);
    }

    protected function handleResponse(Response $response): array
    {
        if ($response->failed()) {
            throw new RuntimeException(
                $response->json('message')
                    ?? $response->body()
                    ?? 'Gateway request failed.'
            );
        }

        return $response->json();
    }
}
