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
            $wine->setDescription(
                'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dignissimos, eligendi illo ab sed corporis, suscipit obcaecati voluptatem consequuntur magnam impedit nobis vel. Voluptate facere, nisi nemo esse id temporibus. Ipsa omnis eius molestias, sed natus quia quis fugiat vel. Maiores porro fuga et inventore doloribus alias omnis vel saepe vitae?'
            );

    
            $manager->persist($wine);
        }

        $manager->flush();
    }
}
