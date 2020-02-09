<?php

namespace App\Controller;

use App\Entity\Wine;
use App\Form\WineType;
use App\Repository\WineRepository;
use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile/wine")
 */
class WineController extends AbstractController
{
    /**
     * @Route("/", name="wine_index", methods={"GET"})
     */
    /*
    public function index(WineRepository $wineRepository): Response
    {
        return $this->render('wine/index.html.twig', [
            'wines' => $wineRepository->findAll(),
        ]);
    }*/

    /**
     * @Route("/profile/new", name="wine_new", methods={"GET","POST"})
     */
    public function new(Request $request, UploaderHelper $uploaderHelper): Response
    {
        $wine = new Wine();
        $form = $this->createForm(WineType::class, $wine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['imageFile']->getData(); 
            if($uploadedFile) {
                $newFilename = $uploaderHelper->uploadArticleImage($uploadedFile);

                $wine->setimageFilename($newFilename);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($wine);
            $entityManager->flush();

            return $this->redirectToRoute('wine');
        }

        return $this->render('wine/new.html.twig', [
            'wine' => $wine,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile/{id}/edit", name="wine_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Wine $wine, UploaderHelper $uploaderHelper): Response
    {
        $form = $this->createForm(WineType::class, $wine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile = $form['imageFile']->getData(); 
            if($uploadedFile) {

                $newFilename = $uploaderHelper->uploadArticleImage($uploadedFile);

                $wine->setimageFilename($newFilename);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('wine');
        }
        return $this->render('wine/edit.html.twig', [
            'wine' => $wine,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile/{id}", name="wine_delete", methods={"DELETE"})
     */ 
    public function delete(Request $request, Wine $wine, UploaderHelper $uploaderHelper): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wine->getId(), $request->request->get('_token'))) {
            $uploaderHelper->removeFile(UploaderHelper::IMAGES, $wine->getImageFilename());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($wine);

            $entityManager->flush();
        }
        return $this->redirectToRoute('wine');
    }
}
