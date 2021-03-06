<?php

namespace App\Controller\Webapp;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicController extends AbstractController
{
    /**
     * @Route("/webapp/public", name="webapp_public")
     */
    public function index(): Response
    {
        return $this->render('webapp/public/index.html.twig', [
            'controller_name' => 'PublicController',
        ]);
    }
}
