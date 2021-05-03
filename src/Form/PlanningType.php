<?php

namespace App\Form;

use App\Entity\Planning;
use App\Entity\Vehicle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanningType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, ["disabled" => true, "label"=>"Date" , 'required' => true])
            ->add('vehicle', EntityType::class , [
                'class' => Vehicle::class,
                "label"=>"Véhicule",
                'placeholder' => 'Aucun',
                'required' => false
            ])
            ->add('schedule')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Planning::class,
        ]);
    }
}
