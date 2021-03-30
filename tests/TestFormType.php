<?php
namespace AgePartnership\Bundle\FormJsValidationBundle\Tests;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * TestFormType
 *
 * Form Type class for testing validators
 *
 */
class TestFormType extends \Symfony\Component\Form\AbstractType
{

    /**
     * buildForm
     *
     * Builds the Test form
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('variable1', TextType::class)
            ->add('variable2', TextType::class)
            ->add('variable3', TextType::class)
            ->add('variable4', TextType::class)
            ->add('variable5', TextType::class)
            ->add('variable6', TextType::class)
            ->add('variable7', TextType::class)
            ->add('variable8', TextType::class);
    }

    /**
     * configureOptions
     *
     * @param Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TestEntity::class
        ]);
    }
}
