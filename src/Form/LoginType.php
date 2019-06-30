<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;




class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
        /// AJOUTER LE PSEUDO DE L'UTILISATEUR.
            ->add('nameUser', TextType::class, array ('label'=>' ', 'attr' => array('class' => 'form-control',
            'placeholder' => 'Pseudo'
            )))

            
        /// AJOUTER LE MOT DE PASSE.    
        ->add('password', PasswordType::class, array('label'=>' ', 'attr' => array(
            'class' => 'form-control',
            'placeholder' => 'Mot de passe'
        ))) 

        /// SAUVEGARDER LE MESSAGE DANS LA BDD.   
        ->add('save', SubmitType::class, array(
            'label' => 'Connexion',
            'attr' => array(
                'class' => 'btn btn-primary btn-margin',
                'title' => 'Connexion'
            )
        ));
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
