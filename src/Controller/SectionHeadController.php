<?php

namespace App\Controller;

use App\Entity\Meal;
use App\Entity\Section;
use App\Form\SectionType;
use App\Repository\SectionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/chefDeSection', name: 'sectionHead')]
class SectionHeadController extends AbstractController
{
    #[Route('/', name: '_home')]
    public function index(Request $request, UserRepository $userRepository, SectionRepository $sectionRepository): Response
    {
        $sections = $sectionRepository->findBy(['sectionhead' => $this->getUser()->getUserIdentifier()]);
        $users = [];
        foreach ($sections as $section) {
            dump($userRepository->findBy(['section' => $section]));
            $users = array_merge($users, $userRepository->findBy(['section' => $section]));
        }
        return $this->render('section_head/index.html.twig', compact('users', 'sections'));
    }

    #[Route('/addWeekMidi', name: '_addWeekMidi')]
    public function modifStagiaireMidi(Request $request, UserRepository $userRepository, SectionRepository $sectionRepository, EntityManagerInterface $entityManager): Response
    {
        $oneWeek = 5;
        $date = new \DateTime($request->request->get('date'));
        $date = $date->modify('monday this week');
        for ($i = 0; $i < $oneWeek; $i++) {
            $exist = $entityManager->getRepository(Meal::class)->findOneBy(['date' => $date, 'user' => $userRepository->findOneBy(['id' => $request->request->get('userId')])]);

            if (!$exist) {
                $meal = new Meal();
                $meal->setDate($date);
                $meal->setUser($userRepository->findOneBy(['id' => $request->request->get('userId')]));
                $meal->setMidi($request->request->get('value') == 'true');
                $meal->setSoir(false);
                $entityManager->persist($meal);
                $entityManager->flush();
            } else {
                $exist->setMidi($request->request->get('value') == 'true');
                $entityManager->flush();
            }
            $date->modify('+1 day');
        }
        return $this->json([]);
    }

    #[Route('/addWeekSoir', name: '_addWeekSoir')]
    public function modifStagiaireSoir(Request $request, UserRepository $userRepository, SectionRepository $sectionRepository, EntityManagerInterface $entityManager): Response
    {
        $oneWeek = 5;
        $date = new \DateTime($request->request->get('date'));
        $date = $date->modify('monday this week');
        for ($i = 0; $i < $oneWeek; $i++) {
            $exist = $entityManager->getRepository(Meal::class)->findOneBy(['date' => $date, 'user' => $userRepository->findOneBy(['id' => $request->request->get('userId')])]);
            if (!$exist) {
                $meal = new Meal();
                $meal->setDate($date);
                $meal->setUser($userRepository->findOneBy(['id' => $request->request->get('userId')]));
                $meal->setSoir($request->request->get('value') == 'true');
                $meal->setMidi(false);
                $entityManager->persist($meal);
                $entityManager->flush();
            } else {
                $exist->setSoir($request->request->get('value') == 'true');
                $entityManager->flush();
            }
            $date->modify('+1 day');
        }
        return $this->json([]);
    }

    #[Route('/addSection', name: '_section')]
    public function addSection(Request $request, EntityManagerInterface $entityManager): Response
    {
        $section = new Section();
        $sectionForm = $this->createForm(SectionType::class, $section);
        $sectionForm->handleRequest($request);
        if ($sectionForm->isSubmitted() && $sectionForm->isValid()) {
            $section->setSectionhead($this->getUser()->getUserIdentifier());
            $entityManager->persist($section);
            $entityManager->flush();
        }
        return $this->renderForm('section_head/addForm.html.twig', compact('sectionForm'));
    }
}
