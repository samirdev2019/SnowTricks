<?php
/**
 * The VideoType file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  VideoType
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Form/VideoType.php
 */
namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Trick;

/**
 * VideoType class
 *
 * @category Class
 * @package  VideoType
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Form/VideoType.php
 */
class VideoType extends AbstractType
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
            //->add('platform')
            ->add(
                'url',
                TextType::class,
                [
                'label'=>'url'
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
        $resolver->setDefaults(['data_class' => Video::class,]);
    }
}
