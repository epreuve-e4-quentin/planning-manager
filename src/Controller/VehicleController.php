<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Vehicle;
use App\Form\VehicleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;




class VehicleController extends AbstractController
{
    /**
     * @Route("/vehicle", name="vehicle")
     */
    public function index(EntityManagerInterface $em): Response
    {
        //Liste de véhicules
        $repo = $em->getRepository(Vehicle::class);
        $vehicles = $repo->findAll();

       
    
        return $this->render('vehicle/index.html.twig', [
            'controller_name' => 'VehicleController',
            'vehicles' => $vehicles
        ]);
    }


    /**
     * @Route("/vehicle/add", name="vehicle_add")
     */
    public function addVehicle (EntityManagerInterface $em, Request $request){
        
        $vehicle = new Vehicle();

        //------------Formulaire-----------
        $form = $this->createForm(VehicleType::class, $vehicle); //Création du formulaire

        $form->handleRequest($request); //Tranfére des données dnas le formulaire
        // dd($form->isValid());

        if( $form->isSubmitted() && $form->isValid() ){ //Si le fourmulaire à été envoyé
           
            //.......Application des données (BDD/Doctrine)........
            $currentUser = $this->getUser();
            $vehicle->setLastUpdateUser( $currentUser); 
            $vehicle->setLastUpdateAt(new \DateTime("now",new \DateTimeZone('Indian/Mauritius'))) ; 

            $em->persist($vehicle);
            $em->flush();

            return $this->redirectToRoute("vehicle");
            //...............................................
        }
        //-----------------------------
        
    
        return $this->render('vehicle/add.html.twig', [
            'form' => $form->createView()
        ]);
    }


    //Condition ci dessous : Accessible si l'ont vas chercher la méthode via json OU  en envois de données avec POST (pas accessible via navigation manuelle)
    /**
    * @Route("/vehicle/{id}/edit", name="vehicle_edit", condition="request.headers.get('accept') matches '/json/' or context.getMethod() in ['POST']")
    */
    public function editVehicle(Vehicle $vehicle, Request $request, EntityManagerInterface $entityManager): Response
    {
        
        //------------Formulaire-----------
        $form = $this->createForm(VehicleType::class, $vehicle); //Création du formulaire

        $form->handleRequest($request); //Transfére des données dnas le formulaire

        if( $form->isSubmitted() && $form->isValid()  ){ //Si le fourmulaire à été envoyé

            //.......Application des données (BDD/Doctrine)........
            $currentUser = $this->getUser();
            $vehicle->setLastUpdateUser( $currentUser); 
            $vehicle->setLastUpdateAt(new \DateTime("now",new \DateTimeZone('Indian/Mauritius'))) ; 
            
            //$data = $form->getData();

            $entityManager->persist($vehicle);
            $entityManager->flush();

            return $this->json(["htmlContent" => "<script> location.replace('/vehicle') ; </script>"], 200) ;
            //................
        }
        //-----------------------------

        //-------------RENDU---------------
        $render = $this->render('vehicle/edit_modal.html.twig', [
            'controller_name' => 'EmployeeController',
            "vehicle" => $vehicle,
            'form' => $form->createView()
        ]);
        
        return $this->json(["htmlContent" => $render->getContent()], 200) ;
        //-----------------------------
    }



    /**
     * @Route("/vehicle/{id}/delete", name="vehicle_delete")
     */
    public function deleteVehicle (Vehicle $vehicle, EntityManagerInterface $em){
        //Suppression de l'entité
        $em->remove($vehicle); 
        $em->flush();
        return $this->redirectToRoute("vehicle"); //Redirection sur la liste des véhicules
    }
    
   
}
