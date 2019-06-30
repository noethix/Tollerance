<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Region;
use App\Entity\Departement;
use App\Entity\Community;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UserType extends AbstractType
{
	/**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

	public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
			->add('avatar', FileType::class, array(
				'required' => false,
				'data_class' => NULL,
				'label' => 'Changer l\'avatar ',
				'attr' => array(
					'placeholder' => 'Changer l\'avatar'
				)
			))

			->add('tagline', TextareaType::class, [
				'required' => false,
				'attr' => array(
					'placeholder' => 'Ta description',
					'class' => 'form-control',
				),
				'label' => ' '

			])
				->add('usersRegion', EntityType::class, array(
					'class' => Region::class,
				    'query_builder' => function (EntityRepository $er) {
				        return $er->createQueryBuilder('r')
				            ->addOrderBy('r.nameRegion', 'ASC');
				    },
					'choice_label' => 'nameRegion',
					'label' => ' ',
    				'placeholder' => 'Région',
    				'attr' => array(
					'class' => 'form-control'
					)
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
					'attr' => array(
					'class' => 'form-control'
					)
				))
				
				->add('city', TextType::class, [
					'required' => true,
					'attr' => array(
						'placeholder' => 'Ta ville',
						'class' => 'form-control',
					),
					'label' => ' '

				])
				

				->add('save', SubmitType::class, array(
				'label' => 'Enregistrer',
				'attr' => array(
					'class' => 'btn btn-primary btn-margin',
					'title' => 'Save'
				)
			));
	}

	/**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Users',
            'validation_groups' => false,
			'route'=>null
        ));
    }

}