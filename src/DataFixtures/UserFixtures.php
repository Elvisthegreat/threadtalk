<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Threadtalk;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $thread = new Threadtalk();
        $thread->setTitle('Welcome to Threadtalk');
        $thread->setDescription('This is the first thread in the Threadtalk application. Feel free to start a discussion!');
        $thread->setCreatedAt(new \DateTimeImmutable());
        $user = $manager->getRepository(User::class)->findOneBy([]);

        if ($user) {
            $thread->setAuthor($user);
        }
 

        $manager->persist($thread);

        $manager->flush();
    }
}
