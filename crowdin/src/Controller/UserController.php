<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use App\Entity\User;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setemail($user['email']);
        $user->setPassword($user['password']);
        $entityManager->persist($user);


        $entityManager->flush();
        return $this->render('user/tanslate.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     *  @Route("/profil", name="profil")
     */

    public function profil()
    {
        return $this->render('user/profil.html.twig');
    }
}
