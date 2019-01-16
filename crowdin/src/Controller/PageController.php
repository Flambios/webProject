<?php


namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;


class PageController extends Controller
{
    /**
     * @Route ("/")
     */

    public function homepage()
    {
        return $this->render('base.html.twig');
    }

    public function showlogin()
    {
        return $this->render('user\login.html.twig');
    }

    public function showprofil()
    {
        return $this->render('user\profil.html.twig');
    }

    public function logout()
    {
        return $this->render('user\logout.html.twig');
    }

    public function createArticle()
    {
        return $this->render('article\create.html.twig');
    }
}