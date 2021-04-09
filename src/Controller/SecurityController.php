<?php

namespace App\Controller;

use dump;
use App\Entity\User ; 
use App\Form\RegistrationType ; 
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class SecurityController extends AbstractController
{

    /**
     * @Route("/users", name="security_list")
     * 
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(EntityManagerInterface $em): Response
    {


        //Liste des uilisate
        $repo = $em->getRepository(User::class);
        $users = $repo->findAll();
     

        return $this->render('security/index.html.twig', [
            'users' => $users
        ]);
    }
     /**
     * @Route("/inscription", name="security_registration")
     * 
     * @IsGranted("ROLE_ADMIN")
     */
    public function Registration(EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $encoder ) 
    {

        $user =new User;

        $form =$this->createForm(RegistrationType::class, $user);
        
        $form->handleRequest($request); //Tranfére des données dans le formulaire

        if( $form->isSubmitted() && $form->isValid() ){ //Si le fourmulaire à été envoyé 

            $hash = $encoder->encodePassword($user,$user->getPassword()) ; 
            $user->setPassword($hash);
            
            $currentUser = $this->getUser();
            $user->setLastUpdateUser( $currentUser); 
            
            $user->setRolesJson ('["ROLE_USER"]'); 
            
            $user->setLastUpdateAt(new \DateTime("now",new \DateTimeZone('Indian/Mauritius'))) ; 
            
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('security_list') ; 
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]); 

    }

    
    //Condition ci dessous : Accessible si l'ont vas chercher la méthode via json OU  en envois de données avec POST (pas accessible via navigation manuelle)
    /**
    * @Route("/users/{id}/edit", name="security_edit", condition="request.headers.get('accept') matches '/json/' or context.getMethod() in ['POST']")
    */
    public function edituser(User $user, EntityManagerInterface $entityManager, Request $request , UserPasswordEncoderInterface $encoder): Response
    {
        
        //------------Formulaire-----------
        $form = $this->createForm(RegistrationType::class, $user); //Création du formulaire

        $form->handleRequest($request); //Transfére des données dnas le formulaire
        if( $form->isSubmitted() && $form->isValid() ){ //Si le fourmulaire à été envoyé

            //.......Application des données (BDD/Doctrine)........
            $hash = $encoder->encodePassword($user,$user->getPassword()) ; 
            $user->setPassword($hash);
            
            $currentUser = $this->getUser();
            $user->setLastUpdateUser( $currentUser); 
            
            //$user->setRolesJson ('["ROLE_USER"]'); 
            
            $user->setLastUpdateAt(new \DateTime("now",new \DateTimeZone('Indian/Mauritius'))) ; 
            $data = $form->getData();
            $entityManager->persist($data);
            $entityManager->flush();

            return $this->json(["htmlContent" => "<script> location.replace('/users') ; </script>"], 200) ;
            //................
        }
        //-----------------------------

        //-------------RENDU---------------
        $render = $this->render('security/edit_modal.html.twig', [
            'controller_name' => 'SecurityController',
            "user" => $user,
            'form' => $form->createView()
        ]);
        
        return $this->json(["htmlContent" => $render->getContent()], 200) ;
        //-----------------------------
    }

    /**
     * @Route("/users/{id}/delete", name="security_delete")
     */
    public function deleteUser (User $user, EntityManagerInterface $em){
        //Suppression de l'entité
        $em->remove($user); 
        $em->flush();
        return $this->redirectToRoute("security_list"); //Redirection sur la liste des utilisateurs
    }

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
