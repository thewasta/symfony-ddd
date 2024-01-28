<?php

namespace App\Shared\Infrastructure\Http;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiRequest
{
    private const HTTP_GET_METHOD = "GET";

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly LoggerInterface     $logger
    ) {}

    public function get(string $url, array $options = [])
    {
        try {
            $this->logger->info('HTTP_CLIENT_REQUEST', ["url" => $url, "options" => $options]);
            return $this->httpClient->request(
                self::HTTP_GET_METHOD,
                $url,
                $options
            );
        } catch (TransportExceptionInterface $e) {
            $this->logger->error('HTTP_CLIENT_REQUEST', ["message" => $e->getMessage()]);
            return null;
        }
    }
}
