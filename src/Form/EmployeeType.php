<?php

namespace App\Form;

use App\Entity\Employee;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ["label"=>"Nom" , 'required' => true])
            ->add('firstname', TextType::class, ["label"=>"Prénom" , 'required' => true])
            ->add('adress', TextType::class, ["label"=>"Adresse" , 'required' => false])
            ->add('zipcode', TextType::class, ["label"=>"Code postal" , 'required' => false])
            ->add('city', TextType::class, ["label"=>"Ville" , 'required' => false])
            ->add('phone', TextType::class, ["label"=>"Téléphone fixe" , 'required' => false])
            ->add('mobilePhone', TextType::class, ["label"=>"Téléphone mobile" , 'required' => false])
            ->add('email', EmailType::class, ["label"=>"Email" , 'required' => false])
            ->add('checkEndDate', CheckboxType::class, ["label"=>"Fin de contrat" , 'required' => false])
            ->add('internal', CheckboxType::class, ["label"=>"Interne" , 'required' => false])
            ->add('enterDate', DateType::class, ["label"=>"Date d'entrée" , 'required' => false])
            ->add('endDate', DateType::class, ["label"=>"Date de fin" , 'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
