<?php

declare(strict_types=1);

namespace App\Shared\Domain\Command;

final class MessageBusResponse
{
    final private function __construct(private readonly array $response) {}

    public static function create(array $response): self
    {
        return new self($response);
    }

    public static function empty(): self
    {
        return new self([]);
    }

    public function response(): array
    {
        return $this->response;
    }
}
