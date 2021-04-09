<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Employee;
use App\Entity\Planning;
use App\Entity\EmployeeView;

use App\Form\EmployeeViewType ;
use App\Form\PlanningFilterType;
use App\Form\PlanningType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @IsGranted("ROLE_USER")
*/
class PlanningController extends AbstractController
{


    /**
     * @Route("/", name="home")
     * @Route("/planning/after", name="planning_after")
     * @Route("/planning", name="planning")
     * 
     */
    
    public function index(Request $request , EntityManagerInterface $em, SessionInterface $session): Response
    {

        // stores an attribute for reuse during a later user request

   
            $previousFormFilterData = $session->get('previous-data-planning-filter');
         ;
            $formFilter = $this->createForm(PlanningFilterType::class);
           
            //Affecte les données précédentes au formulaire 
            if($previousFormFilterData !== null){
                $em->persist($previousFormFilterData['employee']); //Doit absolument persister tous les objets qu'envois le formulaire
                $formFilter->setData($previousFormFilterData);
            }

            $formFilter->handleRequest($request);
            $formData = $formFilter->getData();

        if ( ($formFilter->isSubmitted() && $formFilter->isValid()) || ($previousFormFilterData !== null)  ) {
         
            //Met à jours et sotck les dernière données du formulaire de filtre
            $session->set('previous-data-planning-filter', $formFilter->getData() );
            
                   
            $repoEmployee = $em->getRepository(Employee::class);
            $idEmployee = $repoEmployee->findOneBy(['name' => $formData["employee"]->getName() , 'firstname' => $formData["employee"]->getFirstname() ] );

            // The repository of some entity
            $repoPlanning = $em->getRepository(Planning::class);
            // Run the query using where IN to find by multiple ids
            $plannings = $repoPlanning->createQueryBuilder("planning")
                ->where('planning.employee = :id and  planning.dateSchedule >= :startDate AND  planning.dateSchedule <= :endDate')
                ->setParameter('id', $idEmployee)
                ->setParameter('startDate', $formData["startDate"])
                ->setParameter('endDate',  $formData["endDate"])
                ->getQuery()
                ->getResult();
        
         
            
            //Rendu (vue)
            return $this->render('planning/index.html.twig',[
                'formFilter' => $formFilter->createView(),
                'plannings' => $plannings
             ]);
        }

        //Rendu (vue)
        return $this->render('planning/index.html.twig',[
            'formFilter' => $formFilter->createView()
        ]);
    }
 
    /**
     * @Route("/planning/add", name="planning_add")
     */
    public function addplanning (EntityManagerInterface $em, Request $request){

    }
        
    //Condition ci dessous : Accessible si l'ont vas chercher la méthode via json OU  en envois de données avec POST (pas accessible via navigation manuelle)
    /**
    * @Route("/planning/{id}/edit", name="planning_edit", condition="request.headers.get('accept') matches '/json/' or context.getMethod() in ['POST']")
    */
    public function editplanning(planning $planning, Request $request, EntityManagerInterface $entityManager): Response
    {
         //------------Formulaire-----------
         $form = $this->createForm(PlanningType::class, $planning); //Création du formulaire

         $form->handleRequest($request); //Transfére des données dnas le formulaire
         if( $form->isSubmitted() && $form->isValid()  ){ //Si le fourmulaire à été envoyé
 
             //.......Application des données (BDD/Doctrine)........
             
 
            $currentUser = $this->getUser();
            $planning->setLastUpdateUser( $currentUser); 
            $planning->setLastUpdateAt(new \DateTime("now",new \DateTimeZone('Indian/Mauritius'))) ; 

            $tempDateTime=new \DateTime() ; 
            date_timestamp_set($tempDateTime , (int)date_timestamp_get($planning->getAmplitudeEnd() ) - (int)date_timestamp_get($planning->getAmplitudeStart() ));

            $planning->setAmplitude($tempDateTime  );
             
            $data = $form->getData();
 
            $entityManager->persist($data);
            $entityManager->flush();
 
             return $this->json(["htmlContent" => "<script> location.replace('/planning') ; </script>"], 200) ;
             //................
         }
         //-----------------------------
 


         //-------------RENDU---------------
         $render = $this->render('planning/edit_modal.html.twig', [
             'controller_name' => 'planningController',
             "planning" => $planning,
             'form' => $form->createView()
         ]);
         
         return $this->json(["htmlContent" => $render->getContent()], 200) ;
         //-----------------------------
    }

}