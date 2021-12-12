<?php

namespace App\Controller;

use App\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @Route("/userlogin", name="userlogin")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
      {
         // get the login error if there is one
         $error = $authenticationUtils->getLastAuthenticationError();

         // last username entered by the user
         $lastUsername = $authenticationUtils->getLastUsername();

          return $this->render('login/index.html.twig', [

             'last_username' => $lastUsername,
             'error'         => $error,
          ]);
      }
      /**
       * @Route("/account", name="account")
       */
      public function account(): Response
      {  
         //check if user is loggedIn and authenticated
         $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
         //get user data
         $user = $this->getUser();
         //render template for logined
         return $this->render('login/logined.html.twig',[
            'user' => $user,
         ]);
   
      }
}
