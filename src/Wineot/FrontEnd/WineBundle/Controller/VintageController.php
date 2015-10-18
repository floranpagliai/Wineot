<?php
/**
 * User: floran
 * Date: 11/10/15
 * Time: 22:10
 */

namespace Wineot\FrontEnd\WineBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class VintageController extends Controller
{
    public function showAction($wineName, $vintage, $vintageId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $vintage = $dm->getRepository('WineotDataBundle:Vintage')->find($vintageId);
        $wine = $vintage->getWine();
        if (!$wine && !$vintage)
            throw $this->createNotFoundException('wine.warn.doesntexsit');
        $paramsRender = array('wine' => $wine, 'vintage' => $vintage);
        return $this->render('WineotFrontEndWineBundle:Vintage:show.html.twig', $paramsRender);
    }

}