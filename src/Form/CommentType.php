<?php
/**
 * The CommentType file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  CommentType
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Form/CommentType.php
 */
namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * CommentType class
 *
 * @category Class
 * @package  CommentType
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Form/CommentType.php
 */
class CommentType extends AbstractType
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
            'content',
            TextareaType::class,
            [
            'label' => 'Comment',
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
            'data_class' => Comment::class,
            ]
        );
    }
}
