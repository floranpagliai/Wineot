<?php
/**
 * User: floran
 * Date: 13/06/15
 * Time: 22:26
 */

namespace Wineot\FrontEnd\WineryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WineryController extends Controller
{
    public function showAction($wineryId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $winery = $dm->getRepository('WineotDataBundle:Winery')->find($wineryId);
        if (!$winery)
            throw $this->createNotFoundException('winery.warn.doesntexsit');
        return $this->render('WineotFrontEndWineryBundle:Winery:show.html.twig', array('winery' => $winery));
    }

    public function listWineAction($wineryId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $winery = $dm->getRepository('WineotDataBundle:Winery')->find($wineryId);
        if (!$winery)
            throw $this->createNotFoundException('winery.warn.doesntexsit');
        $wines = $winery->getWines();
        $paramsRender = array('wines' => $wines, 'wineListTitle' => 'winery.title.wines_list');
        return $this->render('WineotFrontEndWineBundle:Wine:list.html.twig', $paramsRender);
    }

    public function bestRatedAction($wineryId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wines = $dm->getRepository('WineotDataBundle:Wine')->findBestRatedWines($wineryId);
        if (is_array($wines))
            $paramsRender = array('wines' => $wines, 'wineListTitle' => 'winery.title.wines_list');
        else {
            $wines = $dm->getRepository('WineotDataBundle:Wine')->findBestRatedWines();
            $paramsRender = array('wines' => $wines, 'wineListTitle' => 'wine.title.trends');
        }
        return $this->render('WineotFrontEndWineBundle:Wine:list.html.twig', $paramsRender);
    }
} 