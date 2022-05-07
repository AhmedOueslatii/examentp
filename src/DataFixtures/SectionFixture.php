<?php

namespace App\DataFixtures;

use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class SectionFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 20; $i++) {
            $section = new Section();
            $section->setDesignation("section".$i);

            $manager->persist($section);
        }
        $manager->flush();
    }
}