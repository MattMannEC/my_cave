<?php

namespace App\DataFixtures;

use App\Entity\Wine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class WineFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 3; $i++) {
            $wine = new Wine();
            $wine->setName('Sexy Red' . $i);
            $wine->setVintage('2000');
            $wine->setGrape('grape');
            $wine->setCountry('country');
            $wine->setRegion('region');
            $wine->setDescription('description');

    
            $manager->persist($wine);
        }

        $manager->flush();
    }
}
