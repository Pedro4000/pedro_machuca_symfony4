<?php

namespace App\Controller\Movies;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\MovieManagerService;
use App\Entity\User;
use App\Entity\FavoriteMovie;
use App\Entity\Comment;
use Symfony\Component\Security\Core\Security;
use App\Form\CommentType;


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

        // Gestion requete ajax pour ajouter/supprimer un favoris

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

        // Formulaire pour ajouter des commentaires

        $comment = new Comment;
        $commentForm = $this->createForm(CommentType::class,$comment);


        $masterRequest = $this->container->get('request_stack')->getMasterRequest();
        if ($masterRequest->getMethod() == 'POST') {


        $createdAt = new \DateTime();

        $commentForm->handleRequest($masterRequest);
        $comment = $commentForm->getData();
        $comment->setUser($user);
        $comment->setIsMovie(true);
        $comment->setMovieDbId($id);
        $comment->setCreatedAt($createdAt);
        $em->persist($comment);
        $em->flush();


        return $this->redirectToRoute('movie_page', [ 'id'=>$id]);

        }

        // Ici on vient récuperer les commentaire liés au film

        $allComments = $em->getRepository(Comment::class)->getCommentsWithId($id,$user);


        return $this->render('movies/movie.html.twig', [
            'controller_name' => 'HomeController',
            'id'=>$id,
            'isCurrentMovieFavorite'=>$isCurrentMovieFavorite,
            'commentForm'=>$commentForm->createView(),
            'comments'=>$allComments
        ]);
    }


}
