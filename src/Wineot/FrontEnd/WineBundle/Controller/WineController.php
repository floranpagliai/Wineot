<?php

namespace Wineot\FrontEnd\WineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\DataBundle\Document\User;
use Wineot\DataBundle\Document\Vintage;

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
        if (!$vintage)
            throw $this->createNotFoundException('wine.warn.notfound');
        $wine = $vintage->getWine();
        $timeline = null;
        if ($vintage->getKeeping() || $vintage->getPeak()) {
            $productionYear =  array(
                'title' => 'wine.title.vintage',
                'date' => array('year' => $vintage->getProductionYear())
            );
            $timeline[] = $productionYear;
            if ($vintage->getPeak())
                $timeline[] = array(
                    'title' => 'wine.title.keeping',
                    'date' => array('year' => $vintage->getPeak())
                );
            if ($vintage->getKeeping())
                $timeline[] = array(
                    'title' => 'wine.title.keeping',
                    'date' => array('year' => $vintage->getKeeping())
                );
        }

        $paramsRender = array('wine' => $wine, 'vintage' => $vintage, 'timeline' => $timeline);
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
