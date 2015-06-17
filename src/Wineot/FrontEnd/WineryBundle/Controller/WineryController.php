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
    public function showAction($wineryName)
    {
        $wineryName = str_replace("-", " ", $wineryName);
        $dm = $this->get('doctrine_mongodb')->getManager();
        $winery = $dm->getRepository('WineotDataBundle:Winery')->findOneBy(array('name' => $wineryName));
        return $this->render('WineotFrontEndWineryBundle:Winery:show.html.twig', array('winery' => $winery));
    }
} 