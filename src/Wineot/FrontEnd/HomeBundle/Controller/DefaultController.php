<?php

namespace Wineot\FrontEnd\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Wineot\DataBundle\Document\User;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WineotFrontEndHomeBundle:Default:index.html.twig');
    }
}
