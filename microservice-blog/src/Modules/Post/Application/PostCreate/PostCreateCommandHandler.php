<?php

declare(strict_types=1);

namespace App\Modules\Post\Application\PostCreate;

use App\Modules\Post\Domain\Post;
use App\Modules\Post\Domain\PostRepository;
use Shared\Infrastructure\Bus\Command\CommandHandler;

class PostCreateCommandHandler implements CommandHandler
{

    public function __construct(public readonly PostRepository $postRepository)
    {
    }

    public function __invoke(PostCreateCommand $command): void
    {
        $post = Post::create(
            $command->userId,
            $command->title,
            $command->content,
            $command->publishedAt
        );

        $this->postRepository->save($post);
    }

}