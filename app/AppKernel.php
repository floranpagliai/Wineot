<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function init()
    {
        date_default_timezone_set( 'Europe/Paris' );
        parent::init();
    }

    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\MongoDBBundle\DoctrineMongoDBBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),
            new Bmatzner\FontAwesomeBundle\BmatznerFontAwesomeBundle(),
            new IsmaAmbrosi\Bundle\GeneratorBundle\IsmaAmbrosiGeneratorBundle(),

            new Utils\NotifyMessengerBundle\UtilsNotifyMessengerBundle(),

            new Wineot\FrontEnd\HomeBundle\WineotFrontEndHomeBundle(),
            new Wineot\UserBundle\WineotUserBundle(),
            new Wineot\StyleGuideBundle\WineotStyleGuideBundle(),
            new Wineot\DataBundle\WineotDataBundle(),
            new Wineot\FrontEnd\SearchBundle\WineotFrontEndSearchBundle(),
            new Wineot\LandingPage\HomeBundle\WineotLandingPageHomeBundle(),
            new Wineot\BackEnd\BackEndBundle\WineotBackEndBackEndBundle(),
            new Wineot\BackEnd\CRUDBundle\WineotBackEndCRUDBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
