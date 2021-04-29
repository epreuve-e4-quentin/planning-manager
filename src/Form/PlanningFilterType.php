<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\Planning;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanningFilterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('employee', EntityType::class , [
                'class' => Employee::class,
                'choice_label' => function(Employee $Employee) {
                    return sprintf('%d - %s %s', $Employee->getId(), $Employee->getName(), $Employee->getFirstname());
                } ,
                "label"=>"Nom"
            ])
            ->add('startDate', DateType::class, ["label"=>"début de période"])
            ->add('endDate', DateType::class, ["label"=>"fin de période"])
            ->add('send', SubmitType::class, ["label"=>"Rechercher"])
            ->add('currentWeek', SubmitType::class, ["label"=>"Semaine courante"])
            ->add('currentMonth', SubmitType::class, ["label"=>"Mois courant"])
        ;   


        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            // ... adding the name field if needed
            $form = $event->getForm();
            
            //Semaine courant
            if( $form->get('currentWeek')->isClicked() ){
                $monday = strtotime("last monday");
                $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
                $mindate = date("Y-m-d",$monday);
                
                
                $minDate = new \DateTime($mindate);
                $maxDate = new \DateTime($mindate." +6 days");
            }

             //Mois courant
            if( $form->get('currentMonth')->isClicked() ){
                
                $minDate = date('01-m-Y');
                $maxDate = date("Y-m-t", strtotime($minDate));

                $minDate = new \DateTime($minDate);
                $maxDate = new \DateTime($maxDate);
            }

            //Si l'ont clique sur mois/semaine actif
            if( $form->get('currentMonth')->isClicked() || $form->get('currentWeek')->isClicked() ){
                $form = $this->changeDateSlotValue($form, $minDate, $maxDate);  
                $newData =  $event->getData();  
                $newData["startDate"] =  $minDate;
                $newData["endDate"] =  $maxDate;
                $event->setData($newData);
    
            }
        

        });
        
    }

    public function changeDateSlotValue($form, $minDate, $maxDate){
        $form->remove("startDate");
        $form->remove("endDate");

        $form->add('startDate', DateType::class, ["label"=>"début de période", 'data'=> $minDate]);
        $form->add('endDate', DateType::class, ["label"=>"fin de période",'data'=> $maxDate]);

        return $form;
    }

    // public function configureOptions(OptionsResolver $resolver)
    // {
    //     $resolver->setDefaults([
    //         'data_class' => Planning::class,
    //     ]);
    // }
}
