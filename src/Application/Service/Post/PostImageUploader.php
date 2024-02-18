<?php

declare(strict_types=1);

namespace App\Application\Service\Post;

use App\Domain\Model\Post\ValueObject\PostMediaPath;
use App\Domain\Model\User\ValueObject\UserAuth0Id;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PostImageUploader
{
    private const PATH = 'post';

    public function __construct() {}

    public function __invoke(UploadedFile $uploadedFile, string $destinationBasePath, UserAuth0Id $userAuthId): string
    {
        $destinationPath = $destinationBasePath . '/public/uploads' . '/' . self::PATH . '/' . $userAuthId->value();
        $original = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $original . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
        $newFilename = PostMediaPath::from($fileName)->toLower();

        $uploadedFile->move(
            $destinationPath,
            $newFilename
        );
        return $newFilename;
    }
}
