<?php

namespace App\DataFixtures;

use App\Entity\Etudiant;
use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EtudiantFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    { $section=New Section();
        $faker = Factory::create('fr');
        for ($i = 0; $i < 20; $i++) {
            $etudiant = new Etudiant();
            $etudiant->setNom($faker->firstName);
            $etudiant->setPrenom($faker->name);

            $manager->persist($etudiant);
        }
        $manager->flush();
    }
}