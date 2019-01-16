<?php


namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Article;
use App\Repository\ArticleRepository;

class ArticleController extends Controller
{

    public function createArticle(Request $request, ObjectManager $manager)
    {

            $article = new Article();

            $article->setTitle("Titre de l'article")
                    ->setContent("Le contenu de l'article");

            $form = $this->createFormBuilder($article)
                    ->add('title')
                    ->add('content')
                    ->add('image')
                    ->getForm();
            $form->handleRequest($request);

            if($form->IsSubmitted() && $form->isValid()) {
                $article->setCreatedAt(new \DateTime());

                $manager->persist($article);
                $manager->flush();

            }

        return $this->render('article\create.html.twig', [
            'formArticle' => $form->createView()
        ]);

        // return $this->redirectToRoute('articles');
    }

    public function showarticles()
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);

        $articles = $repo->findAll();

        return $this->render('article\article.html.twig', ['controller_name', 'ArticleController', 'articles' => $articles ]);
    }
}