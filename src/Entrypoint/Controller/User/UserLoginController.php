<?php

declare(strict_types=1);

namespace App\Entrypoint\Controller\User;

use App\Application\Service\Post\PostRetriever;
use App\Domain\Model\User\User;
use App\Shared\Infrastructure\Security\Auth0Base;
use Auth0\SDK\Exception\ConfigurationException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UserLoginController extends AbstractController
{
    public function __construct(private readonly Auth0Base $auth0,private readonly PostRetriever $retriever) {}

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ConfigurationException
     */
    public function __invoke(Request $request, SessionInterface $session): Response
    {
        if (!$this->container->get('security.token_storage')->getToken()) {
            return $this->redirect($this->auth0->getAuth()->login());
        }
        return $this->redirectToRoute('app_feed');
    }

    public function callback(): Response
    {
        return $this->redirectToRoute('index');
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function success(): Response
    {
        if (!$this->container->get('security.token_storage')->getToken()) {
            return $this->redirectToRoute('app_login');
        }
        /**
         * @var User $user
         */
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $feed = $this->retriever->__invoke();

        $homeFeed = [];
        foreach ($feed as $item) {
            $homeFeed[] = [
                "user_name" => $item->user()->userName()->value(),
                "feed_time" => "Hace 2 horas",
                "feed_description" => $item->message()->value(),
                "feed_photo" => $item->mediaPath()->value(),
            ];
        }
        return $this->render('feed_page.html.twig',[
            "user_name" => $user->userName()->value() . " " . $user->userName()->value(),
            "user_photo" => $user->photo()->value(),
            "feed" => $homeFeed
        ]);
    }
}
