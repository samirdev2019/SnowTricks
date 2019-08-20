<?php

namespace App\Form;

use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Video;
use App\Entity\Illustration;
use App\Form\IllustrationType;




class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('category',EntityType::class,[
            'class'=>Category::class,
            'choice_label'=>'name'
            ])
            // ->add('user',EntityType::class,
            // [
            //     'class'=>User::class,
            //     'choice_label'=>'username'
            // ])
            ->add('name',TextType::class)
            ->add('description',TextareaType::class)
            ->add('videos', CollectionType::class,
            [
                'entry_type' => VideoType::class,
                'entry_options'=>['label'=>false],
                'allow_add' => true,
                'prototype' => true,
                'required' => false,
                'allow_delete' => false,
                'by_reference' => false,
                'error_bubbling' => false,
            ])
            ->add('illustrations',CollectionType::class,
            [
                'entry_type'=>IllustrationType::class,
                'entry_options'=>['label'=>false],
                'allow_add'=>true,
                'prototype'=>true,
                'required'=>false,
                'by_reference'=> false,
                'error_bubbling' => false,
            ])
            
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
