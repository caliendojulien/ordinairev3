<?php

namespace App\Controller;

use App\Repository\MealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

#[Route('/stagiaire', name: 'stagiaire')]
class StagiaireController extends AbstractController
{
    #[Route('/', name: '_decompte')]
    public function decompte(Request $request, MealRepository $mealRepository): Response
    {
       // $meals = $mealRepository->findBy(['card' => $this->getUser()->getUserIdentifier()]);

        $calendar = [];
        for ($i = 0; $i < 21; $i++) {
            $calendar[$i] = strtotime('+' . $i . ' days');
        }

        dump($calendar);
        return $this->render('stagiaire/decompte.html.twig', compact('calendar'));
    }
}
