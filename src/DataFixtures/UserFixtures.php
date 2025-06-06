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
        // Fetch an existing user
        $user = $manager->getRepository(User::class)->findOneBy(['email' => 'amadinelvis6@gmail.com']);

        if ($user) {
            $thread->setAuthor($user); // Assign the user as the author
        } else {
            // Handle case where user is not found
            echo "User not found. Make sure this user exists in the database.\n";
        }

 

        $manager->persist($thread);

        $manager->flush();
    }
}
