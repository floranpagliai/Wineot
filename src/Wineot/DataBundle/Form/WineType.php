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
        $builder->add('color', 'choice', array(
            'choices' => Wine::getColors(),
            'placeholder' => 'crud.form.wine.color',
            'attr' => array(
                'class' => 'select2'
            )
        ));
        $builder->add('containsSulphites', 'checkbox', array(
            'label' => 'crud.form.wine.containsSulphites',
            'required' => false
        ));
        $builder->add('isBio', 'checkbox', array(
            'label' => 'crud.form.wine.isbio',
            'required' => false
        ));
        $builder->add('labelPicture', new ImageType(), array(
            'required' => false
        ));
        $builder->add('bottlePicture', new ImageType(), array(
            'required' => false
        ));
        $builder->add('foodPairings', 'choice', array(
            'choices' => Wine::getFoodTypes(),
            'label' => 'crud.form.wine.food_pairings',
            'placeholder' => 'crud.form.wine.food_pairings',
            'multiple' => true,
//            'expanded' => true,
            'required' => false,
            'attr' => array(
                'class' => 'select2'
            ),));
        $builder->add('vintages', 'collection', array(
            'type' => new VintageType(),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'cascade_validation' => true
        ));
        $builder->add('grappes', 'collection', array(
            'type' => new GrappeSelectorType(),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'cascade_validation' => true
        ));
        $builder->add('winery', 'document', array(
            'class' => 'Wineot\DataBundle\Document\Winery',
            'property' => 'name',
            'placeholder' => 'crud.form.winery',
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
            'data_class' => 'Wineot\DataBundle\Document\Wine'
        ));
    }

    public function getName()
    {
        return 'wineot_databundle_winetype';
    }
}
