<?php
/**
 * The DescriptionType file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  DescriptionType
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Form/DescriptionType.php
 */
namespace App\Form;

use App\Entity\Trick;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * The DescriptionType class
 *
 * @category Class
 * @package  DescriptionType
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Form/DescriptionType.php
 */
class DescriptionType extends AbstractType
{
    /**
     * The buildForm function
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class
            )
            ->add(
                'category',
                EntityType::class,
                [
                'class'=>Category::class,
                'choice_label'=>'name'
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                'label' => '',
                'required' => true,
                'attr' => ['class' => 'tinymce'],
                ]
            );
    }
    /**
     * The configureOptions function
     *
     * @param OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
            'data_class' => Trick::class,
            ]
        );
    }
}
