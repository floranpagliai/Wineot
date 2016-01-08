<?php

namespace Wineot\DataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Wineot\DataBundle\Document\User;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 'email', array(
            'label' => false,
            'attr' => array(
                'placeholder' => 'user.form.placeholder.email'
            )
        ));
        $builder->add('firstname', 'text', array(
            'label' => false,
            'attr' => array(
                'placeholder' => 'user.form.placeholder.firstname'
            )
        ));
        $builder->add('lastname', 'text', array(
            'label' => false,
            'attr' => array(
                'placeholder' => 'user.form.placeholder.lastname'
            )
        ));
        $builder->add('plain_password', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'user.warn.password_match',
            'first_options'  => array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'user.form.placeholder.password'
                )
            ),
            'second_options' => array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'user.form.placeholder.password_validation'
                )
            ),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wineot\DataBundle\Document\User',
        ));
    }

    public function getName()
    {
        return 'wineot_databundle_user';
    }
}