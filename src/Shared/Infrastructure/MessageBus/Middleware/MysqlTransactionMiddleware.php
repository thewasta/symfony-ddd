<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\MessageBus\Middleware;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Throwable;

class MysqlTransactionMiddleware implements MiddlewareInterface
{
    public function __construct(private readonly Connection $connection) {}

    /**
     * @throws Throwable
     * @throws Exception
     */
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $this->connection->beginTransaction();

        try {
            $envelope = $stack->next()->handle($envelope, $stack);
            $this->connection->commit();

            return $envelope;
        } catch (Throwable $exception) {
            $this->connection->rollback();

            throw $exception;
        }
    }
}
