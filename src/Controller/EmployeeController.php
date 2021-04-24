<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
* @IsGranted("ROLE_USER")
*/
class EmployeeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @Route("/home", name="home")
     * @Route("/employee", name="employee")
     */
    public function index(EntityManagerInterface $em): Response
    {
        //Liste des employés
        $repo = $em->getRepository(Employee::class);
        $employees = $repo->findAll();
        
        return $this->render('employee/index.html.twig', [
            'employees' => $employees,
        ]);
    }

    //Condition ci dessous : Accessible si l'ont vas chercher la méthode via json OU  en envois de données avec POST (pas accessible via navigation manuelle)
    /**
     * @Route("/employee/{id}/edit", name="employee_edit", condition="request.headers.get('accept') matches '/json/' or context.getMethod() in ['POST']")
     */
    public function edit(Employee $employee, EntityManagerInterface $entityManager, Request $request): Response
    {
        
        
        //------------Formulaire-----------
        $form = $this->createForm(EmployeeType::class, $employee); //Création du formulaire
        $form->handleRequest($request); //Transfére des données dnas le formulaire
        if( $form->isSubmitted() && $form->isValid() ){ //Si le fourmulaire à été envoyé

            //.......Application des données (BDD/Doctrine)........
            $currentUser = $this->getUser();
            $employee->setLastUpdateUser( $currentUser); 
            $employee->setLastUpdateAt(new \DateTime("now",new \DateTimeZone('Indian/Mauritius'))) ; 
            
            $data = $form->getData();

            $entityManager->persist($data);
            $entityManager->flush();

            return $this->json(["htmlContent" => "<script> location.replace('/employee') ; </script>"], 200) ;
            //................
        }
        //-----------------------------

        //-------------RENDU---------------
        $render = $this->render('employee/edit_modal.html.twig', [
            'controller_name' => 'EmployeeController',
            "employee" => $employee,
            'form' => $form->createView()
        ]);
        
        return $this->json(["htmlContent" => $render->getContent()], 200) ;
        //-----------------------------
    }

    /**
     * @Route("/employee/add", name="employee_add")
     */
    public function add(EntityManagerInterface $em, Request $request){
        $employee = new Employee();

        //------------Formulaire-----------
        $form = $this->createForm(EmployeeType::class, $employee); //Création du formulaire

        $form->handleRequest($request); //Tranfére des données dnas le formulaire
        if( $form->isSubmitted() && $form->isValid() ){ //Si le fourmulaire à été envoyé
            
            //.......Application des données (BDD/Doctrine)........
            if ( ! $employee->getCheckEndDate()) {
                $employee->setEndDate(null);
            }
            $em->persist($employee);
            $em->flush();

            return $this->redirectToRoute("employee");
            //...............................................
        }
        //-----------------------------
        
    
        return $this->render('employee/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/employee/{id}/delete", name="employee_delete")
     */
    public function delete(Employee $employee, EntityManagerInterface $em){
        //Suppression de l'entité
        $em->remove($employee); 
        $em->flush();
        return $this->redirectToRoute("employee"); //Redirection sur la liste des employés
    }
}
