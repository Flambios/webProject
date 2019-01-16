<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixture extends Fixture
{
    private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    public function load(ObjectManager $manager)
    {

        $user = new User();
        $user->setUsername('userdu92');
        $user->setemail('user92@symfony.com');
        $user->setPassword('userword92');
        $manager->persist($user);

        $user->setPassword($this->passwordEncoder->encodePassword($user,'the_new_password'));

        $user = new User();
        $user->setUsername('admin');
        $user->setemail('admin@symfony.com');
        $user->setPassword('adminword75');
        $manager->persist($user);

        $user->setPassword($this->passwordEncoder->encodePassword($user,'the_new_password'));

        $manager->flush();

    }
}
