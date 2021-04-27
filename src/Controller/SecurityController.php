<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\User ; 
use App\Form\RegistrationType ; 
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends AbstractController
{

    /**
     * @Route("/login", name="security_login")
     */
    public function login(): Response
    {
        return $this->render('security/login.html.twig', []); //Rendu sur la page login
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout(): Response
    {
        return $this->render('security/login.html.twig', []); //Rendu sur la page login
    }
}
