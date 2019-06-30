<?php

namespace App\Form;

use App\Entity\Users;
use App\Entity\Events;
use App\Entity\Region;
use App\Entity\Departement;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class DisplayEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    

        $builder
            
        ->add('eventsRegion', EntityType::class, array(
            'class' => Region::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('r')
                    ->orderBy('r.nameRegion', 'ASC');
            },
            'choice_label' => 'nameRegion',
            'label' => ' ',
            'placeholder' => 'région', 
            'attr' => array('class' => 'form-control')
        ))

        ->add('eventsDepartement', EntityType::class, array(
            'class' => Departement::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('d')
                    ->orderBy('d.nameDepartment', 'ASC');
            },
            'choice_label' => 'nameDepartment',
            'label' => ' ',
            'placeholder' => 'département',
            'attr' => array('class' => 'form-control')
        )) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        
        $resolver->setDefaults([
            'data_class' => Events::class,
        ]);
    }
}
