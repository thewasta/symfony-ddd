<?php

declare(strict_types=1);

namespace App\Infrastructure\Subscriber\User;

use App\Domain\Model\User\User;
use Doctrine\DBAL\Connection;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class UserLoginSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly Connection $connection, private readonly LoggerInterface $logger) {}

    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => "onLoginSuccess"
        ];
    }

    public function onLoginSuccess(LoginSuccessEvent $event): void
    {
        try {
            $this->connection->beginTransaction();
            /** @var User $user */
            $user = $event->getUser();
            $query = $this->connection->createQueryBuilder();
            $query->select('*')->from('user')->where('email = :email');
            $query->setParameter('email', $user->email()->value());
            $query->executeStatement();
            $result = $query->fetchAllAssociative();
            if ([] === $result) {
                $this->logger->info(
                    'User not found',
                    [
                        'email' => $user->email()->value(),
                        'username' => $user->username()->value()
                    ]
                );
                $insertQuery = $this->connection->createQueryBuilder();
                $insertQuery->insert('user')
                      ->values(
                          [
                              'auth0_id' => ':uuid',
                              'email' => ':email',
                              'username' => ':username',
                              'first_name' => ':first_name',
                              'last_name' => ':last_name',
                          ]
                      );
                $insertQuery->setParameter('uuid', $user->userId()->value());
                $insertQuery->setParameter('email', $user->email()->value());
                $insertQuery->setParameter('username', $user->username()->value());
                $insertQuery->setParameter('first_name', $user->userName()->value());
                $insertQuery->setParameter('last_name', $user->userName()->value());
                $insertQuery->executeStatement();
            }
            $this->connection->commit();
        } catch (\Exception $exception) {
            $this->logger->error($exception);
            $this->connection->rollBack();
        }
    }
}
