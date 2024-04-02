<?php

namespace App\DataFixtures;

use App\Modules\User\Domain\User;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends BaseFakerFixture
{
    public function load(ObjectManager $manager): void
    {
        $user1 = User::create(
            "fe70c96d-57fd-3d11-8f08-5aa784cb4dc0",
            "user1",
            self::$faker->email,
            self::$faker->firstName,
            self::$faker->lastName,
            true
        );
        $user2 = User::create(
            "a815eafd-9a6c-31bb-9c17-4f98b7648fbc",
            "user2",
            self::$faker->email,
            self::$faker->firstName,
            self::$faker->lastName,
            true
        );
        $manager->persist($user1);
        $manager->persist($user2);

        $manager->flush();
    }
}
