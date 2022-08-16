<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SectionHeadController extends AbstractController
{
    #[Route('/section/head', name: 'app_section_head')]
    public function index(): Response
    {
        return $this->render('section_head/index.html.twig', [
            'controller_name' => 'SectionHeadController',
        ]);
    }
}
