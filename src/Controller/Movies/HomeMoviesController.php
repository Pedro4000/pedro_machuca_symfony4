<?php

namespace App\Controller\Movies;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\MovieManagerService;
use App\Entity\User;
use App\Entity\FavoriteMovie;
use Symfony\Component\Security\Core\Security;

class HomeMoviesController extends AbstractController
{
    /**
     * @Route("/movies", name="home_movies")
     */
    public function moviesIndex()
    {
        return $this->render('movies/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


    /**
     * @Route("/movie/{id}", name="movie_page")
     */
    public function movieAction($id, Request $request, MovieManagerService $movieManager)
    {

        $user =$this->getUser();
        $em = $this->getDoctrine()->getManager();
        intval($id) == 0 ?  $movieId = intval($request->query->get('movie_id')) : $movieId= intval($id) ;

        $favMovieRepo = $em->getRepository(FavoriteMovie::class);
        $isCurrentMovieFavorite = $favMovieRepo->checkIfMovieIsFavorite($movieId, $user);
        empty($isCurrentMovieFavorite) ? $isCurrentMovieFavorite = false : $isCurrentMovieFavorite = true ;


        if($request->isXmlHttpRequest()) {

            $id = $request->query->get('movie_id');
            $specFavMovie = $favMovieRepo->checkIfMovieIsFavorite($id, $user);
        
           if($isCurrentMovieFavorite){
                $em->remove($specFavMovie[0]);
                $em->flush();
            }
            else{
                $message=$movieManager->createMovieIfNotExisting($movieId);
            }   


        }


        return $this->render('movies/movie.html.twig', [
            'controller_name' => 'HomeController',
            'id'=>$id,
            'isCurrentMovieFavorite'=>$isCurrentMovieFavorite
        ]);
    }


}
