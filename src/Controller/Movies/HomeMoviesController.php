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
use Symfony\Component\Form\Extension\Core\Type\TextType;


class HomeMoviesController extends AbstractController
{

    public function __construct(){
        $this->api_key = "2ee2c5b569240ea2a2a879dd9c8a822c";
    }


    /**
     * @Route("/movies", name="home_movies")
     */
    public function moviesIndex(Request $request)
    {
        $masterRequest = $this->container->get('request_stack')->getMasterRequest();






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

    public function researchMovieAction(Request $request)
    {

        $recherche = ['recherche', 'rien'];
        $researchForm = $this->createFormBuilder($recherche)
            ->setAction($this->generateUrl('research_movie'))
            ->setMethod('GET')
            ->add('research', TextType::class, [
                'attr'=>[
                    'class'=> 'bla',
                    'placeholder'=> 'Rechercher un film'
                    ],
                ])
            ->getForm();


        return $this->render('movies/search_movie.html.twig', [
            'numeroro'=>$numeroro=5,
            'researchForm'=>$researchForm->createView()
        ]);
    }

    /**
     * @Route("/movies/research", name="research_movie")
     */    
    public function renderMovieResearchAction(Request $request)
    {


        $masterRequest = $this->container->get('request_stack')->getMasterRequest();
        $recherche = $request->query->get('form')['research'];

        $url = "https://api.themoviedb.org/3/search/movie?api_key=2ee2c5b569240ea2a2a879dd9c8a822c&query=".$recherche."";
        $theMovieDbResponse = json_decode(file_get_contents($url));




        return $this->render('movies/research.html.twig', [
            'numeroro'=>$numeroro=5,
            'theMovieDbResponse'=>$theMovieDbResponse

        ]);



    }



}
