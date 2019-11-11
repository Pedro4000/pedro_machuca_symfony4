<?php

namespace App\Repository;

use App\Entity\FavoriteMovie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FavoriteMovie|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavoriteMovie|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavoriteMovie[]    findAll()
 * @method FavoriteMovie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoriteMovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavoriteMovie::class);
    }

    // /**
    //  * @return FavoriteMovies[] Returns an array of FavoriteMovies objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function checkIfMovieIsFavorite($id, $user)
    {

        $id = intval($id);
        return $this->createQueryBuilder('f')
            ->andWhere('f.user = :user')
            ->andWhere('f.theMovieDbId = :movieId')
            ->setParameter('user', $user)
            ->setParameter('movieId', $id)
            ->getQuery()
            ->getResult();     
    }
    
}
