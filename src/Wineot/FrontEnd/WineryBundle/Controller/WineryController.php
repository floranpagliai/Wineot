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
    public function showAction($wineryName, $wineryId)
    {
        $wineryName = str_replace("-", " ", $wineryName);
        $dm = $this->get('doctrine_mongodb')->getManager();
        $winery = $dm->getRepository('WineotDataBundle:Winery')->findOneBy(array(
            'id' => $wineryId,
            'name' => $wineryName));
        return $this->render('WineotFrontEndWineryBundle:Winery:show.html.twig', array('winery' => $winery));
    }

    public function listWineAction($wineryName, $wineryId)
    {
        $wineryName = str_replace("-", " ", $wineryName);
        $dm = $this->get('doctrine_mongodb')->getManager();
        $winery = $dm->getRepository('WineotDataBundle:Winery')->findOneBy(array(
            'id' => $wineryId,
            'name' => $wineryName));
        $wines = $winery->getWines();
        $paramsRender = array('wines' => $wines, 'wineListTitle' => 'winery.title.wines_list');
        return $this->render('WineotFrontEndWineBundle:Wine:list.html.twig', $paramsRender);
    }

    public function bestRatedAction($wineryName, $wineryId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wines = $dm->getRepository('WineotDataBundle:Wine')->findBestRatedWines($wineryId);
        $paramsRender = array('wines' => $wines, 'wineListTitle' => 'winery.title.wines_list');
        return $this->render('WineotFrontEndWineBundle:Wine:list.html.twig', $paramsRender);
    }
} 