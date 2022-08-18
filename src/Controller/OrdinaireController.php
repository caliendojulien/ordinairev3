<?php

namespace App\Controller;

use App\Repository\MealRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

#[Route('/ordinaire', name: 'ordinaire')]
class OrdinaireController extends AbstractController
{
    #[Route('/', name: '_home')]
    public function home(): Response
    {
        $calendar = [];
        $month = 2;
        for ($i = 0; $i < $month; $i++) {
            $calendar[$i] = strtotime("now +" . $i . " months");
        }
        dump($calendar);


        return $this->render('ordinaire/index.html.twig', compact('calendar'));
    }

    #[Route('/{month}/{year}', name: '_decompte')]
    public function decompte(Request $request, MealRepository $mealRepository, $month, $year, UserRepository $userRepository): Response
    {
        $calendar = [];
        $date = new \DateTime($year . '-' . $month . '-01');
        for ($i = 0; $i < date('t', $date->getTimestamp()); $i++) {
            $calendar[$i] = strtotime('+' . $i . ' days', $date->getTimestamp());
        }
        $meals = $mealRepository->findBetweenDate($date);
        $mealscount = [];

        dump($meals);

        dump($calendar);
        return $this->render('ordinaire/decompte.html.twig', compact('calendar','meals'));
    }
}
