<?php

namespace App\Controller;

use App\Entity\Wine;
use App\Form\WineType;
use App\Service\UploaderHelper;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile/wine")
 */
class WineController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function getSessionUserId()
    {
        $userId = '';
        if ($this->security->getUser()) {
            $userId = $this->security->getUser()->getId();
        }
        return $userId;
    }

    /**
     * @Route("/new", name="wine_new", methods={"GET","POST"})
     */
    public function new(Request $request, UploaderHelper $uploaderHelper): Response
    {
        $wine = new Wine();
        $form = $this->createForm(WineType::class, $wine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wine->setAuthor($this->getSessionUserId());
            $uploadedFile = $form['imageFilename']->getData(); 
            if ($uploadedFile) {
                $newFilename = $uploaderHelper->uploadArticleImage($uploadedFile);
                if ($newFilename) {
                    $wine->setImageFilename($newFilename);
                }
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
     * @Route("/{id}/edit", name="wine_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Wine $wine, UploaderHelper $uploaderHelper): Response
    {
        $form = $this->createForm(WineType::class, $wine);
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid() && $this->getSessionUserId() == $wine->getAuthor()) {
                $currentFilename = $wine->getImageFilename();
                $uploadedFile = $form['imageFilename']->getData(); 
                if ($uploadedFile) {
                    $newFilename = $uploaderHelper->uploadArticleImage($uploadedFile);

                    if ($newFilename) {
                        $wine->setImageFilename($newFilename);
                        $uploaderHelper->removeFile(UploaderHelper::IMAGES, $currentFilename);
                    }
                }
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('wine');
            }

        return $this->render('wine/edit.html.twig', [
            'wine' => $wine,
            'form' => $form->createView(),
            'userId' => $this->getSessionUserId(),
        ]);
    }

    /**
     * @Route("/{id}", name="wine_delete", methods={"DELETE"})
     */ 
    public function delete(Request $request, Wine $wine, UploaderHelper $uploaderHelper): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wine->getId(), $request->request->get('_token')) && $this->getSessionUserId() == $wine->getAuthor()) {
            $uploaderHelper->removeFile(UploaderHelper::IMAGES, $wine->getImageFilename());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($wine);

            $entityManager->flush();

        }
        return $this->redirectToRoute('wine');
    }
}
