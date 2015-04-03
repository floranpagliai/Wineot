<?php
/**
 * User: floran
 * Date: 29/03/15
 * Time: 21:38
 */

namespace Wineot\DataBundle\Twig;

use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\TranslatorInterface;
use Twig_Extension;
use Twig_SimpleFilter;
use Wineot\DataBundle\Document\Wine;

class WineExtension extends Twig_Extension
{
    /** @var \Symfony\Component\Translation\Translator  */
    protected $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('wineColor', array($this, 'wineColor')),
        );
    }

    /**
     * @param $wineColor
     * @param bool $short Set to true to have a shorter text
     * @return string The color of the wine color int given
     */
    public function wineColor($wineColor, $short = false)
    {
        if ($wineColor ==  Wine::COLOR_RED) {
            if ($short)
                return $this->translator->trans('global.wine.color.red_short');
            else
                return $this->translator->trans('global.wine.color.red');
        }
        elseif ($wineColor ==  Wine::COLOR_PINK) {
            if ($short)
                return $this->translator->trans('global.wine.color.pink_short');
            else
                return $this->translator->trans('global.wine.color.pink');
        }
        else {
            if ($short)
                return $this->translator->trans('global.wine.color.white_short');
            else
                return $this->translator->trans('global.wine.color.white');
        }
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'wine_extension';
    }
}