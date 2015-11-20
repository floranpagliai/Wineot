<?php

namespace Wineot\FrontEnd\WineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\DataBundle\Document\User;

class WineController extends Controller
{
    public function redirectWineAction($wineryName, $wineName, $wineId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $vintage = $dm->getRepository('WineotDataBundle:Vintage')->getNewest($wineId);
        if (!$vintage)
            throw $this->createNotFoundException('wine.warn.doesntexsit');
        $params = array(
            'wineryName' => $wineryName,
            'wineName' => $wineName,
            'vintage' => $vintage->getProductionYear(),
            'vintageId' => $vintage->getId());
        return $this->redirect($this->generateUrl('wineot_front_end_wine_show', $params));
    }

    public function showAction($vintageId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $vintage = $dm->getRepository('WineotDataBundle:Vintage')->find($vintageId);
        $wine = $vintage->getWine();
        if (!$wine || !$vintage)
            throw $this->createNotFoundException('wine.warn.doesntexsit');
        $paramsRender = array('wine' => $wine, 'vintage' => $vintage);
        return $this->render('WineotFrontEndWineBundle:Vintage:show.html.twig', $paramsRender);
    }

    public function trendsAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wines = $dm->getRepository('WineotDataBundle:Wine')->findTrendingWines();
        $paramsRender = array('wines' => $wines, 'wineListTitle' => 'wine.title.trends');
        return $this->render('WineotFrontEndWineBundle:Wine:list.html.twig', $paramsRender);
    }

    public function bestRatedAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wines = $dm->getRepository('WineotDataBundle:Wine')->findBestRatedWines();
        $paramsRender = array('wines' => $wines, 'wineListTitle' => 'wine.title.best_rated');
        return $this->render('WineotFrontEndWineBundle:Wine:list.html.twig', $paramsRender);
    }
}
