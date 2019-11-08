<?php

namespace App\Controller\Movies;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\MovieManagerService;
use App\Entity\User;

class HomeMoviesController extends AbstractController
{
    /**
     * @Route("/movies", name="home_movies")
     */
    public function moviesIndex()
    {
        return $this->render('movies/stats_stat_independent_t(arr1, arr2)x.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


    /**
     * @Route("/movie/{id}", name="movie_page")e
     */
    public function movieAction($id, Request $request, MovieManagerService $movieManager)
    {

        $user =$this->getUser();
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository(User::class);


        if($request->isXmlHttpRequest()) {
        $movieId = $request->get('movie_id');
        dump($message=$movieManager->createMovieIfNotExisting($movieId));;die;






        }


        return $this->render('movies/movie.html.twig', [
            'controller_name' => 'HomeController',
            'id'=>$id
        ]);
    }


}
