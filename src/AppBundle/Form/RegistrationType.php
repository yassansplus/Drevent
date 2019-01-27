<?php
// src/AppBundle/Form/RegistrationType.php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('surname')
            ->remove('myDate')
            ->remove('username')
            ->remove('picture')
            ->add('roles', ChoiceType::class, array(
                'attr'  =>  array(),
                'required'=> true,
                'choices' =>
                    array
                    (
                        'Etudiant' => 'ROLE_STUD_OK',
                        'Association' => 'ROLE_ASSOC_OK'
                    ) ,
                'multiple' => true,
                'expanded' => true,
                'required' => true,
            )
        );
    }

     
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}