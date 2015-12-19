<?php

namespace Wineot\DataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('address', 'text', array('attr' => array('placeholder' => 'winery.placeholder.address')));
        $builder->add('town', 'text', array('attr' => array('placeholder' => 'winery.placeholder.town')));
        $builder->add('zipcode', 'text', array('attr' => array('placeholder' => 'winery.placeholder.zipcode')));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wineot\DataBundle\Document\Address'
        ));
    }

    public function getName()
    {
        return 'wineot_databundle_addresstype';
    }
}