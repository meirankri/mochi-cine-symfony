<?php

namespace App\Repository;

use App\Entity\Mochi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Mochi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mochi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mochi[]    findAll()
 * @method Mochi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MochiRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Mochi::class);
    }

//    /**
//     * @return Mochi[] Returns an array of Mochi objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mochi
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByWord($keyword){
        $query = $this->createQueryBuilder('a')
            ->where('a.title LIKE :key')->orWhere('a.synopsis LIKE :key')
            ->orderBy('a.id', 'ASC')
            ->setParameter('key' , '%'.$keyword.'%')->getQuery();
 
        return $query->getResult();
    }
}
