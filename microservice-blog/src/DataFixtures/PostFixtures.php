<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Modules\Post\Domain\Post;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends BaseFakerFixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $userId = ($i % 2 === 0)
                 ? "fe70c96d-57fd-3d11-8f08-5aa784cb4dc0"
                 : "a815eafd-9a6c-31bb-9c17-4f98b7648fbc";
            $post = Post::create(
                $userId,
                "titulo ".$i,
                "texto ".$i,
                new \DateTimeImmutable()
            );
            $this->addReference(sprintf('post.%d', $i), $post);
            $manager->persist($post);
        }
        $manager->flush();
    }

}