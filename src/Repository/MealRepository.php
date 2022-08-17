<?php

namespace App\Repository;

use App\Entity\Meal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use http\Client\Curl\User;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Meal>
 *
 * @method Meal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meal[]    findAll()
 * @method Meal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meal::class);
    }

    public function add(Meal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Meal $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Meal[] Returns an array of Meal objects
//     */
    public function findByUserBetweenDate(\App\Entity\User $user,\DateTime $date): array
    {

        return $this->createQueryBuilder('m')
            ->andWhere('m.user = :user')
            ->setParameter('user',$user)
            ->andWhere('m.date between :dateFirst AND :dateLast')
            ->setParameter('dateFirst',$date->modify('first day of this month')->format('Y-m-d'))
            ->setParameter('dateLast',$date->modify('last day of this month')->format('Y-m-d'))
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Meal
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
