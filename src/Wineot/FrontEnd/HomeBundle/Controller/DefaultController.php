<?php

namespace Wineot\FrontEnd\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WineotFrontEndHomeBundle:Default:index.html.twig');
    }
}
