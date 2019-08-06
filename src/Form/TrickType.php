<?php

namespace App\Form;

use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use App\Entity\User;
use App\Entity\Category;



class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('category',EntityType::class,[
            'class'=>Category::class,
            'choice_label'=>'name'
            ])
            ->add('name',TextType::class)
            ->add('description',TextareaType::class)
            
            
            ->add('videos', CollectionType::class, [
                'entry_type' => VideoType::class,
                'prototype' => true,
                'required' => false,
                'allow_add' => true,
                'allow_delete' => false,
                'by_reference' => false,
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
