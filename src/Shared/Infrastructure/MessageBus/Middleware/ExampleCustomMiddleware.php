<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\MessageBus\Middleware;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class ExampleCustomMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly Stopwatch $stopwatch) {}

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();
        $this->stopwatch->start('MIDDLEWARE TRACE STOPWATCH');
        $envelope = $stack->next()->handle($envelope, $stack);
        $this->stopwatch->stop('MIDDLEWARE TRACE STOPWATCH');
        return $stack->next()->handle($envelope, $stack);
    }
}
