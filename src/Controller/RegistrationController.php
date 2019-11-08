<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserType;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;





class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function registerUser(UserPasswordEncoderInterface $encoder)
    {

        $em= $this->getDoctrine()->getManager();
        $newUser = new User;
    	$registrationForm = $this->createForm(UserType::class, $newUser);


        $masterRequest = $this->container->get('request_stack')->getMasterRequest();
        if ($masterRequest->getMethod() == 'POST') {

            $registrationForm->handleRequest($masterRequest);
            $userToBeCreated = $registrationForm->getData();
            $userToBeCreated->setRoles(['ROLE_USER']);

            if ($registrationForm->isValid()) {

                $encoded = $encoder->encodePassword($userToBeCreated, $userToBeCreated->getPassword());
                $userToBeCreated->setPassword($encoded);

                $em->persist($userToBeCreated);
                $em->flush();

                return $this->redirectToRoute('registration');
            }
        }

        return $this->render('session/register.html.twig', [
            'controller_name' => 'RegistrationController',
            'registrationForm'=>$registrationForm->createView()
        ]);
    }


    /**
     * @Route("/connection", name="connection")
     */
    public function connection(AuthenticationUtils $authenticationUtils): Response
    {


        $em= $this->getDoctrine()->getManager();
        $newUser = new User;
        $connectionForm = $this->createForm(UserType::class, $newUser);


        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('session/connect.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error,
            'registrationForm'=>$connectionForm->createView()


        ]);


        return $this->render('session/connect.html.twig', [
            'controller_name' => 'RegistrationController',
            'registrationForm'=>$connectionForm->createView()
        ]);
    }
}
