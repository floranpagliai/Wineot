<?php

namespace Wineot\DataBundle\Form;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Wineot\DataBundle\Document\Wine;

class WineType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('description', 'textarea');
        $builder->add('color', 'choice', array('choices' => Wine::getColors()));
        $builder->add('labelPicture', new ImageType(), array('required' => false));
        $builder->add('vintages', 'collection', array(
            'type' => new VintageType(),
            'allow_add' => true,
            'by_reference' => false,
        ));
        $builder->add('winery', 'document', array(
            'class' => 'Wineot\DataBundle\Document\Winery',
            'property' => 'name',
            'query_builder' => function (DocumentRepository $er) {
                    return $er->createQueryBuilder('c');
                }
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wineot\DataBundle\Document\Wine'
        ));
    }

    public function getName()
    {
        return 'wineot_databundle_winetype';
    }
}
