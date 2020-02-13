<?php

namespace App\Controller;

use App\Entity\Hero;
use App\Form\HeroType;
use App\Repository\HeroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hero")
 */
class HeroController extends AbstractController
{
    /**
     * @Route("/", name="hero_index", methods={"GET"})
     */
    public function index(HeroRepository $heroRepository): Response
    {
        return $this->render('hero/index.html.twig', [
            'heroes' => $heroRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="hero_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $hero = new Hero();
        $form = $this->createForm(HeroType::class, $hero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hero);
            $entityManager->flush();

            return $this->redirectToRoute('hero_index');
        }

        return $this->render('hero/new.html.twig', [
            'hero' => $hero,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hero_show", methods={"GET"})
     */
    public function show(Hero $hero): Response
    {
        return $this->render('hero/show.html.twig', [
            'hero' => $hero,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="hero_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Hero $hero): Response
    {
        $form = $this->createForm(HeroType::class, $hero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hero_index');
        }

        return $this->render('hero/edit.html.twig', [
            'hero' => $hero,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hero_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Hero $hero): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hero->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hero);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hero_index');
    }
}
