<?php

namespace App\Form;

use App\Entity\Region;
use App\Entity\Groupes;
use App\Entity\Departement;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class GroupeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photoGroup',  FileType::class, array ('label'=>' ', 'required' => false, 'data_class' => NULL, 'attr' => array(
            'placeholder' => "photo pour l'activité"
            )))

            ->add('nameGroup', TextareaType::class, array ('label'=>' ', 'attr' => array('class' => 'form-control',
            'placeholder' => "nom du groupe"
            )))
            
            ->add('descriptionGroupe', TextareaType::class, array ('label'=>' ', 'attr' => array('class' => 'form-control',
            'placeholder' => "donne nous des informations presises sur ton groupe et son but!..."
            )))

            ->add('groupesRegion', EntityType::class, array(
                'class' => Region::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->addOrderBy('r.regionAssimilee', 'ASC')
                        ->addOrderBy('r.nameRegion', 'ASC');
                },
                'choice_label' => 'nameRegion',
                'label' => ' ',
                'placeholder' => 'Région',
                'attr' => array('class' => 'form-control')
                
            
            ))
            ->add('groupesDepartement', EntityType::class, array(
                'class' => Departement::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('d')
                        ->orderBy('d.nameDepartment', 'ASC');
                },
                'choice_label' => 'nameDepartment',
                'label' => ' ',
                'placeholder' => 'Département',
                'attr' => array('class' => 'form-control'),
                
            ))
        ;


        /// SAUVEGARDE DU GROUPE DANS LA BDD.   
        $builder->add('save', SubmitType::class, array(
            'label' => "Et hop! c'est tout bon",
            'attr' => array(
                'class' => 'btn btn-primary btn-margin',
                'title' => 'Création'
            )
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Groupes::class,
        ]);
    }
}
