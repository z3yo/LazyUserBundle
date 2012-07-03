<?php

/**
 * RegistrationFormType.php
 * @package WeCook
 */

namespace WeCook\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use WeCook\UserBundle\Form\UserHandler;
use Symfony\Component\Form\FormInterface;

/**
 * RegistrationFormType
 * @package WeCook
 * @subpackage UserBundle
 * @category Form
 * @author Thomas Quiroga
 */
class RegistrationFormType extends AbstractType
{

    /**
     * Form builder
     * @param FormBuilder $builder
     * @param array $options
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('userlastname')
            ->add('userfirstname')
            ->add('userlogin')
            ->add('useremail', 'email')
            ->add('userpassword', 'repeated', array(
                'type' => 'password',
                "invalid_message"=>"Les mots de passe doivent correspondrent.",
                'first_name'=>"password",
                'second_name'=>"confirmation"
                ))
            ->add('userbirthday','birthday',array('format' => 'dd/MM/yyyy'))
            ->add('cgu','checkbox',array('property_path'=>false, 'required'=> false));

        $builder->addValidator(new CallbackValidator(function(FormInterface $form)
            {
                if (!$form["cgu"]->getData())
                {
                    $form->addError(new FormError("Vous devez accepter les conditions d'utilisation pour pouvoir vous inscrire"));
                }
            })
        );
    }

    /**
     * Returns the name of this form
     * @return string Form name
     */
    public function getName()
    {
        return 'wecookuserbundle_registration';
    }

    /**
     * Conveys an Entity as default class
     * @return array Options
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'WeCook\BaseBundle\Entity\User',
        );
    }    
}