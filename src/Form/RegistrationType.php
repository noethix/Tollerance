<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Region;
use App\Entity\Departement;
use App\Entity\Community;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;



class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
        /// AJOUTER LE PSEUDO DE L'UTILISATEUR.
            ->add('nameUser', TextType::class, array ('label'=>' ', 'attr' => array('class' => 'form-control',
            'placeholder' => 'Pseudo'
            )))

        /// AJOUTER UN EMAIL.    
         ->add('email', EmailType::class, array('label'=>' ', 'attr' => array(
            'class' => 'form-control',
            'placeholder' => 'E-mail'
            )))
            
        /// AJOUTER LE MOT DE PASSE.    
        ->add('password', PasswordType::class, array('label'=>' ', 'attr' => array(
            'class' => 'form-control',
            'placeholder' => 'Mot de passe'
        ))) 
        
         /// CONFIRMER LE MOT DE PASSE.    
         ->add('confirm_password', PasswordType::class, array('label'=>' ', 'attr' => array(
            'class' => 'form-control',
            'title' => 'Confirmer le mot de passe',
            'placeholder' => 'Confirmer le mot de passe'
        )))

        /// AJOUTER UNE LOCALISATION REGION PUIS DEPARTEMENT. 
        
        ->add('usersRegion', EntityType::class, array(
            'class' => Region::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('r')
                    ->orderBy('r.nameRegion', 'ASC');
            },
            'choice_label' => 'nameRegion',
            'label' => ' ',
            'placeholder' => 'Région',
            'attr' => array('class' => 'form-control')
        ))

        ->add('usersDepartment', EntityType::class, array(
            'class' => Departement::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('d')
                    ->orderBy('d.nameDepartment', 'ASC');
            },
            'choice_label' => 'nameDepartment',
            'label' => ' ',
            'placeholder' => 'Département',
            'attr' => array('class' => 'form-control')
        ))

        
         /// AJOUTER LA DATE DE NAISSANCE.
         ->add('birthdateUser', BirthdayType::class, [
            'label'=>'Date de naissance',
            'placeholder' => [
                'id' => 'birthdate',
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
            
            ]
            ]); 
        /// SAUVEGARDER LE MESSAGE DANS LA BDD.   
        $builder
        ->add('save', SubmitType::class, array(
            'label' => "C'est parti !",
            'attr' => array(
                'class' => 'btn btn-primary btn-margin',
                'title' => 'Valider mon inscription'
            )
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
