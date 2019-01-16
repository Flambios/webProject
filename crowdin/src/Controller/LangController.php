<?php
/**
 * Created by PhpStorm.
 * User: anwar.benihissa
 * Date: 02/01/2019
 * Time: 10:13
 */

namespace App\Controller;

use App\Entity\Lang;
use App\Repository\LangRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class LangController extends Controller
{
    /**
     * Lists all lang entities.
     *
     * @Route("/langs", name="langs_index")
     * @Method("GET")
     */

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $lang = $em->getRepository('App:Lang')->findAll();
        return $this->render('lang/index.html.twig', array(
            'lang' => $lang,
        ));
    }

    /**
     * Lists all lang entities.
     *
     * @Route("/my/langs", name="lang_index_my")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */

    public function indexMyAction()
    {
        $em = $this->getDoctrine()->getManager();
        $langs = $em->getRepository('App:Lang')->findBy([
            'user' => $this->getUser()
        ]);
        return $this->render('lang/index.html.twig', array(
            'langs' => $langs,
        ));
    }

    /**
     * Creates a new lang entity.
     *
     * @Route("/lang/new", name="lang_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */

    public function newAction(Request $request)
    {
        $lang = new Lang();
        $form = $this->createForm('App\Form\LangType', $lang);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //$lang->addUser($this->getUsers());
            $em->persist($lang);
            $em->flush();
            return $this->redirectToRoute('langs_index', array('id' => $lang->getId()));
        }
        return $this->render('lang/tanslate.html.twig', array(
            'lang' => $lang,
            'form' => $form->createView(),
        ));
    }
}