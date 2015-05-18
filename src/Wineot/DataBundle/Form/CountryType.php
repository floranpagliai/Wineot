<?php
/**
 * User: floran
 * Date: 18/05/15
 * Time: 18:02
 */

namespace Wineot\DataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CountryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('code', 'text');
//        $builder->add('vintages', 'collection', array(
//            'type' => new RegionType(),
//            'allow_add' => true,
//            'by_reference' => false,
//        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wineot\DataBundle\Document\Country'
        ));
    }

    public function getName()
    {
        return 'wineot_databundle_countrytype';
    }
}