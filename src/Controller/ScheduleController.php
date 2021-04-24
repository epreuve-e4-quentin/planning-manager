<?php

namespace App\Controller;

use App\Entity\Schedule;
use App\Entity\ScheduleTimeWork;
use App\Form\ScheduleType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ScheduleController extends AbstractController
{
    /**
     * @Route("/schedule", name="schedule")
     */
    public function index(EntityManagerInterface $em): Response
    {


        //Liste des horraires
        $repo = $em->getRepository(Schedule::class);
        $schedules = $repo->findAll();
     

        return $this->render('schedule/index.html.twig', [
            'schedules' => $schedules
        ]);
    }
        //, condition="request.headers.get('accept') matches '/json/' or context.getMethod() in ['POST']"
        //Condition ci dessous : Accessible si l'ont vas chercher la méthode via json OU  en envois de données avec POST (pas accessible via navigation manuelle)
    /**
     * @Route("/schedule/{id}/edit", name="schedule_edit")
     */
    public function edit(Schedule $schedule, Request $request, EntityManagerInterface $entityManager): Response
    {

        //------------Formulaire-----------
        $form = $this->createForm(ScheduleType::class, $schedule); //Création du formulaire

        $form->handleRequest($request); //Transfére des données dnas le formulaire
      

        if( $form->isSubmitted() && $form->isValid() ){ //Si le fourmulaire à été envoyé

            //.......Application des données (BDD/Doctrine)........
            //Calcul du temps de travail effectif si forcé n'est pas checké 
            if ( ! $schedule->getdefaultForced() ) {
                $secondes = (int)date_timestamp_get($schedule->getdefaultAmplitude()); 
                $secondes = $secondes * $schedule->getamplitudeCoeff();
                $tempDateTime=new \DateTime() ; 
                date_timestamp_set($tempDateTime , $secondes);
                $schedule->setTimeWork($tempDateTime);

            } else {
                $tempDateTime=new \DateTime() ; 
                date_timestamp_set($tempDateTime ,0);
                $schedule->setTimeWork($tempDateTime);
            }

            $data = $form->getData();
            $entityManager->persist($data);
            $entityManager->flush();
            //................
            return $this->json(["htmlContent" => "<script> location.replace('/schedule') ; </script>"], 200) ; 
        }
        //-----------------------------

        //-------------RENDU---------------
        
        $render = $this->render('schedule/edit_modal.html.twig', [
            'controller_name' => 'EmployeeController',
            "schedule" => $schedule,
            'form' => $form->createView()
        ]);
        
        return $this->json(["htmlContent" => $render->getContent()], 200) ;
        //-----------------------------
    }

    /**
     * @Route("/schedule/add", name="schedule_add")
     */
    public function add(EntityManagerInterface $em, Request $request){
        $schedule = new Schedule();

        //------------Formulaire-----------
        $form = $this->createForm(ScheduleType::class, $schedule); //Création du formulaire

        $form->handleRequest($request); //Tranfére des données dans le formulaire
        if( $form->isSubmitted()  && $form->isValid() ){ //Si le fourmulaire à été envoyé
            
            //.......Application des données (BDD/Doctrine)........
            
            $currentUser = $this->getUser();
            $schedule->setLastUpdateUser( $currentUser); 
            $schedule->setLastUpdateAt(new \DateTime("now",new \DateTimeZone('Indian/Mauritius'))) ; 
            
            //Calcul du temps de travail effectif si forcé n'est pas checké 
            if ( ! $schedule->getdefaultForced() ) {
                $secondes = (int)date_timestamp_get($schedule->getdefaultAmplitude()); 
                $secondes = $secondes * $schedule->getamplitudeCoeff();
                $tempDateTime=new \DateTime() ; 
                date_timestamp_set($tempDateTime , $secondes);
                $schedule->setTimeWork($tempDateTime);

            } else {
                $tempDateTime=new \DateTime() ; 
                date_timestamp_set($tempDateTime ,0);
                $schedule->setTimeWork($tempDateTime);
            }

            $em->persist($schedule);
            $em->flush();

            return $this->redirectToRoute("schedule");
            //...............................................
        }
        
    
        return $this->render('schedule/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/schedule/{id}/delete", name="schedule_delete")
     */
    public function delete(Schedule $schedule, EntityManagerInterface $em){
        //Supression de l'entité
        $em->remove($schedule);
        $em->flush();
        return $this->redirectToRoute("schedule"); //Redirection sur la liste des horraire
    }
}
