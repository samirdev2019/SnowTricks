<?php
/**
 * The IllustrationType file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  IllustrationType
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Form/IllustrationType.php
 */
namespace App\Form;

use App\Entity\Illustration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;

/**
 * The IllustrationType class
 *
 * @category Class
 * @package  IllustrationType
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Form/IllustrationType.php
 */
class IllustrationType extends AbstractType
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
                'url',
                FileType::class,
                [
                'label'=> 'select an image',
                'mapped'=>false,
                //'multiple'=>true,
                'required'=>false,
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
            'data_class' => Illustration::class,
            ]
        );
    }
}
