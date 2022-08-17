<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/', name: 'main')]
class MainController extends AbstractController
{
    #[Route('/', name: '_home')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/infos', name: '_infos')]
    public function infos(): Response
    {
        return $this->render('main/infos.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
