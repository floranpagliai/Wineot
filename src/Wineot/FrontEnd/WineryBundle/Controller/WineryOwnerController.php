<?php
/**
 * User: floran
 * Date: 27/01/2016
 * Time: 21:27
 */

namespace Wineot\FrontEnd\WineryBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\DataBundle\Document\Winery;

class WineryOwnerController extends Controller
{

    public function showAction($wineryId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        /** @var Winery $winery */
        $winery = $dm->getRepository('WineotDataBundle:Winery')->find($wineryId);
        $widgets = new ArrayCollection();

        $widgets->add(array(
            'title' => 'Note moyenne',
            'key' => $winery->getAvgRating(),
            'icon' => 'fa fa-star'
        ));
        $widgets->add(array(
            'title' => 'Commentaire',
            'key' => sizeof($winery->getComments()),
            'icon' => 'fa fa-commenting'
        ));
        $widgets->add(array(
            'title' => 'Nombres de vues',
            'key' => 63,
            'icon' => 'fa fa-eye'
        ));
        $paramsRender = array('winery' => $winery, 'widgets' => $widgets);
        return $this->render('WineotFrontEndWineryBundle:WineryOwner:dashboard.html.twig', $paramsRender);
    }

    public function listAction(Request $request)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $ownings = $dm->getRepository('WineotDataBundle:Winery')->getOwnings($this->getUser()->getId());
        $paramsRender = array('ownings' => $ownings);
        return $this->render('WineotFrontEndWineryBundle:Winery:list.html.twig', $paramsRender);
    }
}