<?php
/**
 * Created by PhpStorm.
 * User: anwar.benihissa
 * Date: 02/01/2019
 * Time: 10:13
 */

namespace App\Controller;

use App\Entity\Lang;
use App\Entity\Target;
use App\Repository\LangRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TargetController extends Controller
{
    /**
     * Creates a new project entity.
     *
     * @Route("/new_translate/new", name="project_newc")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */

    public function newAction(Request $request)
    {
        $target = new Target();
        $form = $this->createForm('App\Form\TargetType', $target);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //$lang->addUser($this->getUsers());
            $em->persist($target);
            $em->flush();
            return $this->redirectToRoute('project_show', array('id' => $target->getId()));
        }
        return $this->render('target/new.html.twig', array(
            'target' => $target,
            'form' => $form->createView(),
        ));
    }
}