<?php

namespace App\Controller;

use App\Entity\Wine;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\HeroRepository;
use App\Repository\UserRepository;
use App\Repository\WineRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/")
 */
class DefaultController extends AbstractController
{

    /**
     * @Route ("/", name="home")
     */
    public function index(WineRepository $wineRepository, HeroRepository $heroRepository, ArticleRepository $articleRepository)
    {
        return $this->render('index.html.twig', [
            'heroElements' => $heroRepository->readHeros(),
            'sliderElements' => $wineRepository->readWines(),
            'articleElements' => $articleRepository->readArticles(),
            'currentUser' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/wine", name="wine", methods={"GET"})
     */
    public function wineCatalogue(WineRepository $wineRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $q = $request->query->get('q');
        $queryBuilder = $wineRepository->getWithSearchQueryBuilder($q);

        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6/*limit per page*/
        );

        return $this->render('wine/index.html.twig', [
            'pagination' => $pagination,
            'currentUser' => $this->getUser(),
        ]);
    } 

    /**
     * @Route("/wine/{id}", name="wine_show", methods={"GET"})
     */
    public function show(Wine $wine, UserRepository $userRepository): Response
    {
        $authorObject = $userRepository->readUser($wine->getAuthor());
        $author = $authorObject->getUsername();
        return $this->render('wine/show.html.twig', [
            'wine' => $wine,
            'author' => $author,
            'currentUser' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show", methods={"GET"})
     */
    public function articleShow(Article $article): Response
    {
        return $this->render('admin/article/show.html.twig', [
            'article' => $article,
            'currentUser' => $this->getUser(),
        ]);
    }
}