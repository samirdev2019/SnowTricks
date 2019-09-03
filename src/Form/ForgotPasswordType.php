<?php
/**
 * The ForgotPasswordType file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  ForgotPasswordType
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Form/ForgotPasswordType.php
 */
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * The ForgotPasswordType class
 *
 * @category Class
 * @package  ForgotPasswordType
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Form/ForgotPasswordType.php
 */
class ForgotPasswordType extends AbstractType
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
            ->add('username');
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
        $resolver->setDefaults([]);
    }
}
