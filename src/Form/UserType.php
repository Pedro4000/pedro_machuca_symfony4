<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    // ...

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'attr'=>['placeholder'=>'Adresse mail']
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr'=>['placeholder'=>'Prénom']
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom de famille',
                'attr'=>['placeholder'=>'Nom de famille']
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'attr'=>['placeholder'=>'Mot de passe']
            ])
        ;
    }
}