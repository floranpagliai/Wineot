<?php
/**
 * User: floran
 * Date: 25/11/2015
 * Time: 21:51
 */

namespace Wineot\DataBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TasteProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('sweetLevel', 'choice', array(
            'label' => 'wine.form.sweet_level',
            'choices' => array(0 => "Velouté", 1 => "Doux", 2 => "Moelleux", 3 => "Liquoreux", 4 => "Sirupeux"),
            'placeholder' => 'wine.form.placeholder.taste_profile_level',
            'required' => false,
            'attr' => array(
                'class' => 'select2'
            )
        ));
        $builder->add('fruitsLevel', 'choice', array(
            'label' => 'wine.form.fruits_level',
            'choices' => array(0 => "Non fruité", 1 => "Peu fruité", 2 => "Fruité", 3 => "Assez fruité", 4 => "Très fruité"),
            'placeholder' => 'wine.form.placeholder.fruits_level',
            'required' => false,
            'attr' => array(
                'class' => 'select2'
            )
        ));
        $builder->add('woodedLevel', 'choice', array(
            'label' => 'wine.form.wodded_level',
            'choices' => array(0 => "Non boisé", 1 => "Peu boisé", 2 => "Boisé", 3 => "Assez boisé", 4 => "Très boisé"),
            'placeholder' => 'wine.form.placeholder.wodded_level',
            'required' => false,
            'attr' => array(
                'class' => 'select2'
            )
        ));
        $builder->add('strengthLevel', 'choice', array(
            'label' => 'wine.form.strenght_level',
            'choices' => array(0 => "Faible", 1 => "Généreux", 2 => "Gras", 3 => "Capiteux", 4 => "Alcooleux"),
            'placeholder' => 'wine.form.placeholder.strenght_level',
            'required' => false,
            'attr' => array(
                'class' => 'select2'
            )
        ));
        $builder->add('tanninsLevel', 'choice', array(
            'label' => 'wine.form.tannins_level',
            'choices' => array(0 => "Lisse", 1 => "Fondu", 2 => "Charpenté", 3 => "Chargé", 4 => "Âpre"),
            'placeholder' => 'wine.form.placeholder.tannins_level',
            'required' => false,
            'attr' => array(
                'class' => 'select2'
            )
        ));
        $builder->add('complexLevel', 'choice', array(
            'label' => 'wine.form.complex_level',
            'choices' => array(0 => "Très simple", 1 => "Simple", 2 => "Normal", 3 => "Complexe", 4 => "Très complexe"),
            'placeholder' => 'wine.form.placeholder.sweet_level',
            'required' => false,
            'attr' => array(
                'class' => 'select2'
            )
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wineot\DataBundle\Document\TasteProfile'
        ));
    }

    public function getName()
    {
        return 'wineot_databundle_tasteprofiletype';
    }
}