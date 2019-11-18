<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     * @param ArticleRepository $repo
     * @return Response
     */
    public function index( ArticleRepository $repo )
    {
        $articles = $repo -> findAll();
        return $this -> render( 'blog/index.html.twig', [
            'articles' => $articles
        ] );
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this -> render( 'blog/home.html.twig', [
            'title' => 'Salut mec',
            'age'   => 31
        ] );
    }

    /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     * @param Article $article
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     * @throws \Exception
     */
    public function form( Article $article = null, Request $request, ObjectManager $manager )
    {
        if(!$article) {
            $article = new Article();
        }
        $form = $this -> createForm( ArticleType::class, $article );
        $form -> handleRequest( $request );
        if($form -> isSubmitted() && $form -> isValid()) {
            if(!$article -> getId()) {
                $article -> setCreatedAt( new \DateTime() );
            }
            $manager -> persist( $article );
            $manager -> flush();
            return $this -> redirectToRoute( 'blog_show', [
                'id' => $article -> getId()
            ] );
        }
        return $this -> render( 'blog/new.html.twig', [
            'form'     => $form -> createView(),
            'editMode' => $article -> getId() !== null
        ] );
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     * @param Article $article
     * @return Response
     */
    public function show( Article $article, Request $request, ObjectManager $manager )
    {
        $comment=new Comment();
        $form = $this -> createForm( CommentType::class,$comment );
        $form->handleRequest($request);
        if($form -> isSubmitted() && $form -> isValid()) {
            $comment
                ->setCreatedAt(new \DateTime())
                ->setArticle($article);

            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('blog_show',[
                'id'=>$article->getId()
            ]);
        }
        return $this -> render( 'blog/show.html.twig', [
            'article' => $article,
            'commentForm'=>$form->createView()
        ] );
    }

}
