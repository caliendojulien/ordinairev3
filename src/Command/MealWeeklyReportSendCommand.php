<?php

namespace App\Command;

use App\Repository\MealRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Validator\Constraints\Date;

#[AsCommand(
    name: 'app:meal-monthly-report:send',
    description: 'send the meal report every week',
)]
class MealWeeklyReportSendCommand extends Command
{
    private MealRepository $mealRepository;
    private $mailer;

    public function __construct(MealRepository $mealRepository, MailerInterface $mailer)
    {
        parent::__construct(null);

        $this->mealRepository = $mealRepository;

        $this->mailer = $mailer;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $calendar = [];
        $date = new \DateTime();
        $meals = $this->mealRepository->findBetweenDate($date);
        dump($meals);
        $date->modify('first day of this month');
        for ($i = 0; $i < date('t', $date->getTimestamp()); $i++) {
            $calendar[$i] = strtotime('+' . $i . ' days', $date->getTimestamp());
        }
        $io->progressStart(count($meals));
        foreach ($meals as $meal) {
            $io->progressAdvance();
        }
        $email = (new TemplatedEmail())
            ->from('marvin.lepeillet@gmail.com')
            ->to('marvin.lepeillet@gmail.com')
        ->subject('Rapport du mois des repas')
        ->htmlTemplate('email/mealordinaire.html.twig')
        ->context(compact('meals','calendar'));
        $this->mailer->send($email);
        $io->progressFinish();
        $io->success("Monthly mail has been sent");
        return 0;
    }
}
