<?php

namespace Wineot\StyleGuideBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WineotStyleGuideBundle:StyleGuide:index.html.twig');
    }
}
