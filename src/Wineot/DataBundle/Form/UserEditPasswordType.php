<?php

namespace Wineot\DataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Wineot\DataBundle\Document\User;

class UserEditPasswordType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $builder->add('password', 'password');
        $builder->add('plain_password', 'repeated', array(
            'type' => 'password',
            'invalid_message' => 'Les mots de passe doivent correspondre',
            'first_options'  => array('label' => 'Mot de passe'),
            'second_options' => array('label' => 'Mot de passe (validation)'),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wineot\DataBundle\Document\User',
            'validation_groups' => array('Edit')
        ));
    }

    public function getName()
    {
        return 'wineot_databundle_usereditpassword';
    }
}