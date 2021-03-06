<?php
/**
 * Created by PhpStorm.
 * User: anwar.benihissa
 * Date: 02/01/2019
 * Time: 10:13
 */

namespace App\Controller;

use App\Entity\Source;
use App\Entity\Project;

use App\Form\SourceType;
use App\Form\SourceImportType;
use App\Repository\LangRepository;
use phpDocumentor\Reflection\Types\Object_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SourceController extends Controller
{

    /**
     * Lists all source entities.
     *
     * @Route("/source", name="source_index")
     * @Method("GET")
     */

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $sources = $em->getRepository('App:Source')->findAll();
        return $this->render('source/index.html.twig', array(
            'source' => $sources,
        ));
    }

    /**
     * Creates a new source entity.
     *
     * @Route("/source/new", name="source_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */

    public function newAction(Request $request)
    {
        $source = new Source();
        $form = $this->createForm('App\Form\SourceType', $source);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($source);
            $em->flush();
            return $this->redirectToRoute('source_index', array('id' => $source->getId()));
        }
        return $this->render('source/new.html.twig', array(
            'source' => $source,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new source entity.
     *
     * @Route("/import/new", name="source_csv")
     * @Method({"GET", "POST"})
     */
    public function import(Request $request)
    {
            $source = new Source();
            $form = $this->createForm(SourceImportType::class, $source);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $form->get('code')->getData();

                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('csv_directory'),
                        $fileName
                    );
                } catch (FileException $e) {

                }

                $source->setCode($fileName);
                return $this->redirect($this->generateUrl('source_index'));
            }

            return $this->render('source/import.html.twig', array(
                'form' => $form->createView(),
            ));
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    public function read_csv()
    {
        $row = 1;
        if (($handle = fopen("test.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                echo "<p> $num champs à la ligne $row: <br /></p>\n";
                $row++;
                for ($c=0; $c < $num; $c++) {
                    echo $data[$c] . "<br />\n";
                }
            }
            fclose($handle);
        }
        return $this->redirect($this->generateUrl('source_index'));
    }
}

