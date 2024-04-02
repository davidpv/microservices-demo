<?php

declare(strict_types=1);

namespace App\Modules\User\Application\UserEnable;

use App\Modules\Post\Domain\Post;
use App\Modules\Post\Domain\PostRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use function Lambdish\Phunctional\map;

#[AsMessageHandler]
readonly class UserEnabledMessageHandler
{

    public function __construct(private PostRepository $postRepository)
    {
    }

    public function __invoke(UserEnabledMessage $message): void
    {
        $posts = $this->postRepository->getAll();
        map(function (Post $post) use ($message) {
            if ($post->userId->value() === $message->userId) {
                $post->show();
                $this->postRepository->save($post);
            }
        }, $posts);
    }

}