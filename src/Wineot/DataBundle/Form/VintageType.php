<?php
/**
 * User: floran
 * Date: 30/03/15
 * Time: 17:16
 */

namespace Wineot\DataBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VintageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('productionYear', 'choice', array(
            'choices' => array_combine(range(date('Y'), date('Y')-100),range(date('Y'), date('Y')-100))));
        $builder->add('wineryPrice', 'money');
        $builder->add('labelPicture', new ImageType(), array('required' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wineot\DataBundle\Document\Vintage'
        ));
    }

    public function getName()
    {
        return 'wineot_databundle_vintagetype';
    }
}