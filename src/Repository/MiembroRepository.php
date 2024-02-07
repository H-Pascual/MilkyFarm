<?php

namespace App\Repository;

use App\Entity\Miembro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Miembro>
 *
 * @method Miembro|null find($id, $lockMode = null, $lockVersion = null)
 * @method Miembro|null findOneBy(array $criteria, array $orderBy = null)
 * @method Miembro[]    findAll()
 * @method Miembro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MiembroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Miembro::class);
    }

//    /**
//     * @return Miembro[] Returns an array of Miembro objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Miembro
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
