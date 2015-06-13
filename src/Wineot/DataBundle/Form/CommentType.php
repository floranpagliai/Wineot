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

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('comment', 'textarea');
        $builder->add('rank', 'choice', array('choices' => array(1,2,3,4,5)));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wineot\DataBundle\Document\Comment'
        ));
    }

    public function getName()
    {
        return 'wineot_databundle_commenttype';
    }
}