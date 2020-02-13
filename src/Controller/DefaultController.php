<?php

namespace App\Controller;

use App\Entity\Wine;
use App\Repository\HeroRepository;
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
    public function index(WineRepository $wineRepository, HeroRepository $heroRepository)
    {
        return $this->render('index.html.twig', [
            'heroElements' => $heroRepository->readHeros(),
            'sliderElements' => $wineRepository->readWines(),
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
        ]);
    } 

    /**
     * @Route("/wine/{id}", name="wine_show", methods={"GET"})
     */
    public function show(Wine $wine): Response
    {
        return $this->render('wine/show.html.twig', [
            'wine' => $wine,
        ]);
    }
}