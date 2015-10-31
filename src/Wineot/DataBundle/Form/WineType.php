<?php

namespace Wineot\DataBundle\Form;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Wineot\DataBundle\Document\FoodPairing;
use Wineot\DataBundle\Document\Wine;

class WineType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('description', 'textarea', array(
            'label' => 'wine.form.description',
            'required' => false,
            'attr' => array(
                'rows' => '15'
            )
        ));
        $builder->add('color', 'choice', array(
            'label' => 'wine.form.color',
            'choices' => Wine::getColors(),
            'placeholder' => 'crud.form.wine.color',
            'attr' => array(
                'class' => 'select2'
            )
        ));
        $builder->add('labelPicture', new ImageType(), array(
            'label' => 'wine.form.label_picture',
            'required' => false
        ));
        $builder->add('bottlePicture', new ImageType(), array(
            'label' => 'wine.form.bottle_picture',
            'required' => false
        ));
        $builder->add('foodPairings', 'choice', array(
            'label' => 'wine.form.food_pairings',
            'choices' => Wine::getFoodTypes(),
            'placeholder' => 'crud.form.wine.food_pairings',
            'multiple' => true,
//            'expanded' => true,
            'required' => false,
            'attr' => array(
                'class' => 'select2'
            )
        ));
        $builder->add('vintages', 'collection', array(
            'label' => 'wine.form.vintages',
            'type' => new VintageType(),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'cascade_validation' => true
        ));
        $builder->add('grappes', 'collection', array(
            'label' => 'wine.form.grappes',
            'type' => new GrappeSelectorType(),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'cascade_validation' => true,
            'attr' => array(
                'class' => 'grappe-collection',
            ),
        ));
        $builder->add('winery', 'document', array(
            'label' => 'wine.form.winery',
            'class' => 'Wineot\DataBundle\Document\Winery',
            'property' => 'name',
            'placeholder' => 'wine.placeholder.winery',
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
