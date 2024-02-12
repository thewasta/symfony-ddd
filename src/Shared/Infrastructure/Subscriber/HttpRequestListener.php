<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class HttpRequestListener
{
    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => ['onLoginSuccess', 100],
        ];
    }

    public function onLoginSuccess(LoginSuccessEvent $event)
    {
        $user = $event->getUser();
        dd("asdasda");
    }

}
