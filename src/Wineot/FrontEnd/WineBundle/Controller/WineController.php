<?php

namespace Wineot\FrontEnd\WineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\DataBundle\Document\User;

class WineController extends Controller
{
    public function showAction($wineName, $wineId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine = $dm->getRepository('WineotDataBundle:Wine')->find($wineId);
        if (!$wine)
            throw $this->createNotFoundException('wine.warn.doesntexsit');
        $paramsRender = array('wine' => $wine);
        return $this->render('WineotFrontEndWineBundle:Wine:show.html.twig', $paramsRender);
    }

    public function trendsAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wines = $dm->getRepository('WineotDataBundle:Wine')->findTrendingWines();
        $paramsRender = array('wines' => $wines, 'wineListTitle' => 'wine.title.trends');
        return $this->render('WineotFrontEndWineBundle:Wine:list.html.twig', $paramsRender);
    }
}
