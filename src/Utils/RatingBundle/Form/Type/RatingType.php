<?php
/**
 * User: floran
 * Date: 17/06/15
 * Time: 09:50
 */

namespace Utils\RatingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RatingType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'expanded' => true,
            'attr' => array(
                'class' => 'rating',
            ),
            'choices' => array(
                1 => '1',
                2 => '2',
                3 => '3',
                4 => '4',
                5 => '5',
            ),
            'data' => 3
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'rating';
    }
}