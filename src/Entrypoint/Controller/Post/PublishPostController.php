<?php

declare(strict_types=1);

namespace App\Entrypoint\Controller\Post;

use App\Application\Command\Post\CreateImagePostCommand;
use App\Shared\Domain\Command\MessageAppBusInterface;
use App\Shared\Entrypoint\Controller\BaseController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class PublishPostController extends BaseController
{
    public function __construct(private readonly MessageAppBusInterface $bus) {}

    public function __invoke(Request $request): Response
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('file_01');
        $message = $request->get("message");
        $this->bus->dispatch(
            new CreateImagePostCommand(
                $file,
                $this->getParameter('kernel.project_dir'),
                $message,
                $this->getUser()
            )
        );
        return $this->redirectToRoute('app_login_success');
    }
}
