<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CMSController extends AbstractController
{
    /**
     * @Route("/c/m/s", name="c_m_s")
     */
    public function index()
    {
        return $this->render('cms/index.html.twig', [
            'controller_name' => 'CMSController',
        ]);
    }
}
