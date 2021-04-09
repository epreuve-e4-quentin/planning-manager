<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\EmployeeView;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EmployeeViewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', EntityType::class , [
            'class' => Employee::class,
            'choice_label' => function(Employee $Employee) {
                return sprintf('%d - %s %s', $Employee->getId(), $Employee->getName(),$Employee->getFirstname());
            } ,
            "label"=>"Nom"
        ])
        ->add('startDate', DateType::class, ["label"=>"début de période"])
        ->add('endDate', DateType::class, ["label"=>"fin de période"])
        ->add('send', SubmitType::class, ["label"=>"Rechercher"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EmployeeView::class,
        ]);
    }
}
