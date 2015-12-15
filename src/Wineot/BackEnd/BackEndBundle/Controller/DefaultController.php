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

        $crudMenu->add(array(
            'route' => 'wineot_back_end_homepage',
            'name' => 'crud.title.admin',
            'routes' => array('wineot_back_end_homepage')
        ));
        $crudMenu->add(array(
            'route' => 'wineot_back_end_admin_wine',
            'name' => 'crud.title.admin_wines',
            'routes' => array('wineot_back_end_admin_wine')
        ));
        $paramsRender = array('menu' => $crudMenu, 'menuTitle' => 'Administration');
        return $this->render('blocks/menu.html.twig', $paramsRender);
    }
}
