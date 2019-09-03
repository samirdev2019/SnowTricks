<?php
/**
 * The TrickType file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  TrickType
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Form/TrickType.php
 */
namespace App\Form;

use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Video;
use App\Entity\Illustration;
use App\Form\IllustrationType;

/**
 * TrickType class
 *
 * @category Class
 * @package  TrickType
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Form/TrickType.php
 */
class TrickType extends AbstractType
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
                'category',
                EntityType::class,
                [
                'class'=>Category::class,
                'choice_label'=>'name'
                ]
            )
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add(
                'videos',
                CollectionType::class,
                [
                'entry_type' => VideoType::class,
                'entry_options'=>['label'=>false],
                'allow_add' => true,
                'prototype' => true,
                'required' => false,
                'allow_delete' => false,
                'by_reference' => false,
                'error_bubbling' => false,
                ]
            )
            ->add(
                'illustrations',
                CollectionType::class,
                [
                'entry_type'=>IllustrationType::class,
                'entry_options'=>['label'=>false],
                'allow_add'=>true,
                'prototype'=>true,
                'required'=>false,
                'mapped'=>true,
                'allow_file_upload'=>true,
                'by_reference'=> false,
                'error_bubbling' => false,
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
        $resolver->setDefaults(['data_class' => Trick::class,]);
    }
}
