<?php
/**
 * User: floran
 * Date: 11/09/15
 * Time: 10:59
 */

namespace Wineot\DataBundle\Form;


use Doctrine\ODM\MongoDB\DocumentRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GrappeSelectorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('grappe', 'document', array(
                'class' => 'Wineot\DataBundle\Document\Grappe',
                'property' => 'name',
                'attr' => array(
                    'class' => 'select2'
                ),
                'query_builder' => function (DocumentRepository $er) {
                        return $er->createQueryBuilder('c');
                    }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wineot\DataBundle\Document\WineGrappe'
        ));
    }

    public function getName()
    {
        return 'wineot_databundle_grappeselectortype';
    }
}