<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 3; $i++) {
            $user = new User();
            $user->setUsername('David' . $i);
    
            $password = $this->encoder->encodePassWord($user, 'david');
            $user->setPassword($password);
    
            $manager->persist($user);
        }

        $manager->flush();
    }

}
