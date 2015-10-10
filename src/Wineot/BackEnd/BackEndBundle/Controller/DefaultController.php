<?php

namespace Wineot\BackEnd\BackEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN'))
            return $this->redirect($this->generateUrl('wineot_front_end_homepage'));

        $dm = $this->get('doctrine_mongodb')->getManager();
        $winesCount = $dm->getRepository('WineotDataBundle:Wine')->getCount();
        $paramsRender = array('winesCount' => $winesCount);
        return $this->render('WineotBackEndCRUDBundle:Default:index.html.twig', $paramsRender);
    }
}
