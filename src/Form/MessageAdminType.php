<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class MessageAdminType extends AbstractType
{
	
    /**
         * @param FormBuilderInterface $builder
         * @param array $options
         */
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder
            ///  AJOUTER LE SUJET DE CONVERSATION.
            ->add('subjectMessage', ChoiceType::class, array('label'=>' ',
            'choices' => array(
                'Signaler un problème technique'    => 'probleme_technique',
                'Signaler un problème avec un utilisateur'    => 'probleme_utilisateur',
                'Faire un compliment'    => 'compliment',
                'Autre'    => 'autre',
            ),
            'placeholder'=>'Choisis une raison',
            'attr' => array(
                'class' => 'form-control',
                'title' => 'Raison',
            )
        ))
            ///  AJOUTER LE CONTENU DU MESSAGE.    
                ->add('contentMessage', TextareaType::class, array('label'=>' ', 'attr' => array(
                    'class' => 'form-control',
                    'title' => 'message',
                )));
                
            /// SAUVEGARDE LE MESSAGE DANS LA BDD.   
            $builder->add('save', SubmitType::class, array(
                'label' => 'Envoyer',
                'attr' => array(
                    'class' => 'btn btn-primary btn-margin',
                    'title' => 'Envoyer'
                )
            ));
                    
        }
        
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Messages',
			'route'=>null
        ));
    }

}
