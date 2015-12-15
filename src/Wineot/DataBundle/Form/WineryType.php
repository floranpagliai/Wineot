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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Wineot\DataBundle\Document\Country;

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
            'placeholder' => 'winery.form.country',
            'attr' => array(
                'class' => 'select2'
            ),
            'query_builder' => function (DocumentRepository $er) {
                    return $er->createQueryBuilder('c');
                }
        ));

        $formModifier = function (FormInterface $form, Country $country = null) {
            $regions = null === $country ? array() : $country->getRegions();

            $form->add('region', 'document', array(
                'class'       => 'Wineot\DataBundle\Document\Region',
                'property' => 'name',
                'placeholder' => 'winery.form.region',
                'choices'     => $regions,
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();

                $formModifier($event->getForm(), $data->getCountry());
            }
        );

        $builder->get('country')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $country = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $country);
            }
        );

//        $builder->addEventListener(
//            FormEvents::PRE_SET_DATA,
//            function(FormEvent $event) {
//                $data = $event->getData();
//                $country = $data->getCountry();
//                $regions = null === $country ? array() : $country->getRegions();
//                $form = $event->getForm();
//                if ($regions) {
//                    $form->add('region', 'document', array(
//                        'class' => 'Wineot\DataBundle\Document\Region',
//                        'property' => 'name',
//                        'placeholder' => 'crud.form.winery.region',
//                        'attr' => array(
//                            'class' => 'select2'
//                        ),
//                        'choices' => $regions
//                    ));
//                } else {
//                    $form->add('region', 'document', array(
//                        'class' => 'Wineot\DataBundle\Document\Region',
//                        'property' => 'name',
//                        'placeholder' => 'crud.form.winery.region',
//                        'attr' => array(
//                            'class' => 'select2'
//                        ),
//                        'disabled' => true
//                    ));
//                }
//
//
//            }
//        );
//        $builder->add('region', 'document', array(
//            'class' => 'Wineot\DataBundle\Document\Region',
//            'property' => 'name',
//            'attr' => array(
//                'class' => 'select2'
//            ),
//            'query_builder' => function (DocumentRepository $er) {
//                    return $er->createQueryBuilder('c');
//                }
//        ));
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