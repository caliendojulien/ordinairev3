<?php

namespace App\Controller;

use App\Entity\Meal;
use App\Repository\MealRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

#[Route('/stagiaire', name: 'stagiaire')]
class StagiaireController extends AbstractController
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


        return $this->render('stagiaire/index.html.twig', compact('calendar'));
    }

    #[Route('/{month}/{year}', name: '_decompte')]
    public function decompte(Request $request, MealRepository $mealRepository, $month, $year , UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(['card'=>$this->getUser()->getUserIdentifier()]);
        $meals= $mealRepository->findByUserBetweenDate($user, \DateTime::createFromFormat('Y-m-d',$year.'-'.$month.'-01'));
        $calendar = [];

        $date = new \DateTime($year . '-' . $month . '-01');
        dump(date('t', $date->getTimestamp()));
        for ($i = 0; $i < date('t', $date->getTimestamp()); $i++) {
            $calendar[$i] = strtotime('+' . $i . ' days', $date->getTimestamp());
        }

        dump($calendar);
        return $this->render('stagiaire/decompte.html.twig', compact('calendar','meals'));
    }

    #[Route('/addMidi', name: '_addMidi')]
    public function addMidi(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $exist = $entityManager->getRepository(Meal::class)->findOneBy(['date' => new \DateTime($request->request->get('date')), 'user' => $userRepository->findOneBy(['id' => $request->request->get('userId')])]);
        dump(new \DateTime($request->request->get('date')));
        if (!$exist) {
            $meal = new Meal();
            $meal->setDate(new \DateTime($request->request->get('date')));
            $meal->setUser($userRepository->findOneBy(['id' => $request->request->get('userId')]));
            $meal->setMidi($request->request->get('value') == 'true');
            $meal->setSoir(false);
            $entityManager->persist($meal);
            $entityManager->flush();
        } else {
            $exist->setMidi($request->request->get('value') == 'true');
            $entityManager->flush();
        }
        return $this->json($exist);
    }

    #[Route('/addSoir', name: '_addSoir')]
    public function addSoir(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, MealRepository $mealRepository): Response
    {
        $exist = $entityManager->getRepository(Meal::class)->findOneBy(['date' => new \DateTime($request->request->get('date')), 'user' => $userRepository->findOneBy(['id' => $request->request->get('userId')])]);
        dump((int)$request->request->get('userId'));
        if (!$exist) {
            $meal = new Meal();
            $meal->setDate(new \DateTime($request->request->get('date')));
            $meal->setUser($userRepository->findOneBy(['id' => $request->request->get('userId')]));
            $meal->setMidi(false);
            $meal->setSoir($request->request->get('value') == 'true');
            $entityManager->persist($meal);
            $entityManager->flush();
        } else {
            dump($request->request->get('value'));
            $exist->setSoir($request->request->get('value') == 'true');
            $entityManager->flush();
        }
        $exist = $entityManager->getRepository(Meal::class)->findOneBy(['date' => new \DateTime($request->request->get('date'))]);

        return $this->json($exist);
    }

    #[Route('/addMidi', name: '_addMidi')]
    public function addMidi(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $exist = $entityManager->getRepository(Meal::class)->findOneBy(['date' => new \DateTime($request->request->get('date')), 'user' => $userRepository->findOneBy(['id' => $request->request->get('userId')])]);
        dump(new \DateTime($request->request->get('date')));
        if (!$exist) {
            $meal = new Meal();
            $meal->setDate(new \DateTime($request->request->get('date')));
            $meal->setUser($userRepository->findOneBy(['id' => $request->request->get('userId')]));
            $meal->setMidi($request->request->get('value') == 'true');
            $meal->setSoir(false);
            $entityManager->persist($meal);
            $entityManager->flush();
        } else {
            $exist->setMidi($request->request->get('value') == 'true');
            $entityManager->flush();
        }
        return $this->json($exist);
    }

    #[Route('/addSoir', name: '_addSoir')]
    public function addSoir(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, MealRepository $mealRepository): Response
    {
        $exist = $entityManager->getRepository(Meal::class)->findOneBy(['date' => new \DateTime($request->request->get('date')), 'user' => $userRepository->findOneBy(['id' => $request->request->get('userId')])]);
        dump((int)$request->request->get('userId'));
        if (!$exist) {
            $meal = new Meal();
            $meal->setDate(new \DateTime($request->request->get('date')));
            $meal->setUser($userRepository->findOneBy(['id' => $request->request->get('userId')]));
            $meal->setMidi(false);
            $meal->setSoir($request->request->get('value') == 'true');
            $entityManager->persist($meal);
            $entityManager->flush();
        } else {
            dump($request->request->get('value'));
            $exist->setSoir($request->request->get('value') == 'true');
            $entityManager->flush();
        }
        $exist = $entityManager->getRepository(Meal::class)->findOneBy(['date' => new \DateTime($request->request->get('date'))]);

        return $this->json($exist);}
}