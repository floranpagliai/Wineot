<?php

namespace Wineot\BackEnd\BackEndBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
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
        return $this->render('WineotBackEndBackEndBundle:Default:index.html.twig', $paramsRender);
    }

    public function renderMenuAction()
    {
        $crudMenu = new ArrayCollection();
        $dm = $this->get('doctrine_mongodb')->getManager();

        $crudMenu->add(array(
            'route' => 'wineot_back_end_homepage',
            'name' => 'backend.title.admin',
            'routes' => array('wineot_back_end_homepage')
        ));
        $crudMenu->add(array(
            'route' => 'wineot_back_end_admin_wine',
            'name' => 'backend.title.admin_wines',
            'routes' => array('wineot_back_end_admin_wine'),
            'badge' => sizeof($dm->getRepository('WineotDataBundle:Wine')->findBy(array('isVerified' => false)))
        ));
        $crudMenu->add(array(
            'route' => 'wineot_back_end_admin_winery_owning',
            'name' => 'backend.title.admin_owning',
            'routes' => array('wineot_back_end_admin_winery_owning'),
            'badge' => sizeof($dm->getRepository('WineotDataBundle:Winery')->findBy(array('owning.is_verified' => false)))
        ));
        $paramsRender = array('menu' => $crudMenu, 'menuTitle' => 'backend.title.admin');
        return $this->render('blocks/menu.html.twig', $paramsRender);
    }
}
