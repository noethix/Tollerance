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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PostType extends AbstractType
{
	/**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

	public function buildForm(FormBuilderInterface $builder, array $options) {
			$builder
				->add('contentPost', TextType::class, [
					
    				'attr' => array(
						'placeholder' => 'dis nous...',
						'class' => 'form-control'					),
					'label' => ' '
				])


				->add('save', SubmitType::class, array(
					'label' => 'envoie',
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
            'data_class' => 'App\Entity\Posts',
			'route'=>null
        ));
    }

}