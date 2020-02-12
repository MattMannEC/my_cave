<?php

// src/Controller/DefaultController.php
namespace App\Controller;

use App\Entity\Wine;
use App\Form\WineType;
use App\Repository\WineRepository;
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
    public function index(WineRepository $wineRepository)
    {
        return $this->render('index.html.twig', [
            'sliderElements' => $wineRepository->readWines(),
        ]);
    }

    /**
     * @Route("/wine", name="wine", methods={"GET"})
     */
    public function wineCatalogue(WineRepository $wineRepository, Request $request): Response
    {
        $q = $request->query->get('q');
        return $this->render('wine/index.html.twig', [
            'wines' => $wineRepository->findAllWithSearch($q),
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