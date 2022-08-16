<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrdinaireController extends AbstractController
{
    #[Route('/ordinaire', name: 'app_ordinaire')]
    public function index(): Response
    {
        return $this->render('ordinaire/index.html.twig', [
            'controller_name' => 'OrdinaireController',
        ]);
    }
}
