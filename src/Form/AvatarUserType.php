<?php
/**
 * The AvatarUserType file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  AvatarUserType
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Form/AvatarUserType.php
 */
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

/**
 * The AvatarType class
 *
 * @category Class
 * @package  AvatarUserType
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Form/AvatarUserType.php
 */
class AvatarUserType extends AbstractType
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
                'avatar',
                FileType::class,
                [
                'label' => 'your image',
                'mapped' =>false,
                'required'=>false ,
                'constraints' => [
                    new File(
                        [
                        'mimeTypesMessage' => 'Please upload a valid image file',
                        ]
                    )
                ],
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
            'data_class' => User::class,
            ]
        );
    }
}
