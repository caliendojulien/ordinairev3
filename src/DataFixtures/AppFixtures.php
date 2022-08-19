<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $user = new User();

         $user->setCard('123456789');
         $user->setFirstname('admin');
         $user->setName('admin');
         $user->setGrade('ADM');
         $user->setRoles(["ROLE_CDS","ROLE_ADMIN"]);
         $user->setPassword('$2y$13$ZnbQZrnbbgPV4uaRFbb7QukFLXQbI5Kfw5mzxxVZa/aFq9V2lLKtW');

         $manager->persist($user);

        $manager->flush();
    }
}
