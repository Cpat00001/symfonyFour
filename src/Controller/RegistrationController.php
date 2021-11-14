<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function index(Request $request , UserPasswordHasherInterface $passwordHasher): Response
    {
        //create a User object and initialize some data
        $user = new User();
        //connet to DB
        $entityManager = $this->getDoctrine()->getManager();
        // $user->setEmail('test1@testowy.com');
        // $user->setRoles(['ROLE_USER']);
        // $user->setPassword('1234');

        //use a form created in UserType.php
        $form = $this->createForm(UserType::class, $user);
        //handle submitted form
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //get user input data
            $user = $form->getData();
            //set user rola as 'ROLE_USER'
            $user->setRoles(['ROLE_USER']);
            //get password and HASH it
            $plainUserPassword = $user->getPassword();
            var_dump($plainUserPassword);
            // hash the password (based on the security.yaml config for the $user class)
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plainUserPassword
            );
            $user->setPassword($hashedPassword);
            //tell Doctrine,you want to eventually save the User
            $entityManager->persist($user);
            //save user to DB Table User (INSERT INTO)
            $entityManager->flush();
            //redirect after submitting data
            return new Response('You have been registered as ' . $user->getUserIdentifier() . 
                                ' <br> email as: ' . $user->getEmail() . ' 
                                 You can login now.' . '<a href="userlogin">Login</a>' );  
        }
        //return and render form
        return $this->renderForm('registration/index.html.twig', [
            'form' => $form,
            'user' => $user,
            // 'userRole' => $user_role,
        ]);
    }
}
