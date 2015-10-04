<?php

namespace Wineot\DataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Wineot\DataBundle\Document\User;

class UserEditCrudType extends UserType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options) ;
        $builder->remove('plain_password');
        $builder->add('roles', 'choice', array(
                'choices' => User::getRolesType(),
                'multiple' => true,
                'expanded' => true,
                )
            );
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
        return 'wineot_databundle_usereditcrud';
    }
}