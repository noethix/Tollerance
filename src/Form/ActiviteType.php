<?php

namespace App\Form;

use App\Entity\Region;
use App\Entity\Activites;
use App\Entity\Departement;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ActiviteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photoActivites',  FileType::class, array ('label'=>' ', 'required' => false, 'data_class' => NULL, 'attr' => array(
            'placeholder' => "photo pour l'activité"
            )))

            ->add('nameActvites', TextareaType::class, array ('label'=>' ', 'attr' => array('class' => 'form-control',
            'placeholder' => "nom de l'activité"
            )))
            
            ->add('locationActivites', TextType::class, array ('label'=>' ', 'attr' => array('class' => 'form-control',
            'placeholder' => 'où ça aura lieu...'
            )))
            
            ->add('dateActivites', DateTimeType::class, array ('label'=>' ',
             'date_widget'=>'single_text',
            'time_widget'=>'single_text','attr' => array('class' => 'form-control',
            'placeholder' => 'la date!'
            )))

            ->add('priceActivite', NumberType::class, array ('label'=>' ', 'attr' => array('class' => 'form-control',
            'placeholder' => 'prix'
            )))

            

            ->add('descriptionActivites', TextareaType::class, array ('label'=>' ', 'attr' => array('class' => 'form-control',
            'placeholder' => "raconte nous ce que c'est..."
            )))
            
            
            
            

            ->add('Region', EntityType::class, array(
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

            ->add('Departement', EntityType::class, array(
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

        
        ;

         /// SAUVEGARDE L'ACTIVITE DANS LA BDD.   
         $builder->add('save', SubmitType::class, array(
            'label' => 'création',
            'attr' => array(
                'class' => 'btn btn-primary btn-margin',
                'title' => 'Création'
            )
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activites::class,
        ]);
    }
}
