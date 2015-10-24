<?php

namespace Wineot\DataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Wineot\DataBundle\Document\User;

class EmailType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('mail', 'email');
    }


    public function getName()
    {
        return 'wineot_databundle_email';
    }
}