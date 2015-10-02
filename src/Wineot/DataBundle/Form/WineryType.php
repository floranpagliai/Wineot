<?php
/**
 * User: floran
 * Date: 31/03/15
 * Time: 18:13
 */

namespace Wineot\DataBundle\Form;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WineryType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('mail');
        $builder->add('phone');
        $builder->add('address', new AddressType(), array('required' => false));
        $builder->add('coverPicture', new ImageType(), array('required' => false));
        $builder->add('country', 'document', array(
            'class' => 'Wineot\DataBundle\Document\Country',
            'property' => 'name',
            'attr' => array(
                'class' => 'select2'
            ),
            'query_builder' => function (DocumentRepository $er) {
                    return $er->createQueryBuilder('c');
                }
        ));
        $builder->add('region', 'document', array(
            'class' => 'Wineot\DataBundle\Document\Region',
            'property' => 'name',
            'attr' => array(
                'class' => 'select2'
            ),
            'query_builder' => function (DocumentRepository $er) {
                    return $er->createQueryBuilder('c');
                }
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wineot\DataBundle\Document\Winery'
        ));
    }

    public function getName()
    {
        return 'wineot_databundle_winerytype';
    }
}