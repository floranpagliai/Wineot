<?php

namespace Wineot\FrontEnd\SearchBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('searchInput', 'text', array(
            'attr' => array(
                'placeholder' => 'wine.action.search',
                'class' => 'search-field form-control input-lg'
            )
        ));
    }

    public function getName()
    {
       return 'search';
    }
}
