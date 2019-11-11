<?php 

namespace App\Service;


use App\Entity\User;
use App\Entity\FavoriteMovie;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;


class MovieManagerService
{

    public function __construct(Security $security, EntityManagerInterface $em){

        $this->security = $security;
        $this->em = $em;
    }


    public function createMovieIfNotExisting($id)
    {

        $currentUser =$this->security->getUser();
        $favoriteMovie = new FavoriteMovie;
        $favoriteMovie->setTheMovieDbId($id);
        $favoriteMovie->setUser($currentUser);
        $this->em->persist($favoriteMovie);
        $this->em->flush();
    }

    public function deleteFavorite($favoriteMovie){

        

    }


}