<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function index(Request $request): Response
    {
        //create a User object and initialize some data
        $user = new User();
        // $user->setEmail('test1@testowy.com');
        // $user->setRoles(['ROLE_USER']);
        // $user->setPassword('1234');

        //create a temporary form in controller
        $form = $this->createForm(UserType::class, $user);
           
        return $this->renderForm('registration/index.html.twig', [
            'form' => $form,
        ]);
    }
}
