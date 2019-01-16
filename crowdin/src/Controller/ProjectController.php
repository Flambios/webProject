<?php
/**
 * Created by PhpStorm.
 * User: anwar.benihissa
 * Date: 02/01/2019
 * Time: 10:12
 */

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Target;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProjectController extends Controller
{
    /**
     * Lists all project entities.
     *
     * @Route("/projects", name="project_index")
     * @Method("GET")
     */

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $projects = $em->getRepository('App:Project')->findAll();
        return $this->render('project/index.html.twig', array(
            'projects' => $projects,
        ));
    }

    /**
     * Lists all project entities.
     *
     * @Route("/my", name="project_index_my")
     * @Method("GET")
     * @Security("has_role('ROLE_USER')")
     */

    public function indexMyAction()
    {
        $em = $this->getDoctrine()->getManager();
        $projects = $em->getRepository('App:Project')->findBy([
            'user' => $this->getUser()
        ]);
        return $this->render('project/index.html.twig', array(
            'projects' => $projects,
        ));
    }

    /**
     * Creates a new project entity.
     *
     * @Route("/new_projects/new", name="project_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */

    public function newAction(Request $request)
    {
        $project = new Project();

        $form = $this->createForm('App\Form\ProjectType', $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $project->setUser($this->getUser());
            $em->persist($project);
            $em->flush();
            return $this->redirectToRoute('project_show', array('id' => $project->getId()));
        }
        return $this->render('project/new.html.twig', array(
            'project' => $project,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a project entity.
     *
     * @Route("/show_projects/{id}", name="project_show")
     * @Method("GET")
     * @param Project $project
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function showAction(Project $project)
    {
        $deleteForm = $this->createDeleteForm($project);
        return $this->render('project/show.html.twig', array(
            'project' => $project,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing project entity.
     *
     * @Route("/edit_project/{id}", name="project_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER') && user == project.getUser()")
     * @param Request $request
     * @param Project $project
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Project $project, Request $request)
    {
        $deleteForm = $this->createDeleteForm($project);
        $editForm = $this->createForm('App\Form\ProjectType', $project);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('project_edit', array('id' => $project->getId()));
        }
        return $this->render('project/edit.html.twig', array(
            'project' => $project,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a project entity.
     *
     * @Route("/delete_project/{id}", name="project_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_USER') && user == project.getUser()")
     * @param Request $request
     * @param Project $project
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */

    public function deleteAction(Request $request, Project $project)
    {
        $form = $this->createDeleteForm($project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($project);
            $em->flush();
        }
        return $this->redirectToRoute('project_index');
    }

    /**
     * Creates a form to delete a project entity.
     *
     * @param Project $project The project entity
     *
     * @return \Symfony\Component\Form\Form The form
     */

    private function createDeleteForm(Project $project)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('project_delete', array('id' => $project->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

}