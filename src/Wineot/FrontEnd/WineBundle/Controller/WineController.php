<?php

namespace Wineot\FrontEnd\WineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WineController extends Controller
{
    public function showAction($wineName)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine = $dm->getRepository('WineotDataBundle:Wine')->findOneBy(array('name'=>$wineName));
        return $this->render('WineotFrontEndWineBundle:Wine:show.html.twig', array('wine' => $wine));
    }
}
