<?php

namespace Wineot\BackEnd\CRUDBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN'))
            return $this->redirect($this->generateUrl('wineot_front_end_homepage'));
        return $this->render('WineotBackEndCRUDBundle:Default:index.html.twig');
    }

    public function renderMenuAction()
    {
        $crudMenu = new ArrayCollection();

        $crudMenu->add(array(
            'route' => 'wineot_back_end_crud_winery',
            'name' => 'crud.title.wineries',
            'routes' => array('wineot_back_end_crud_winery', 'wineot_back_end_crud_winery_add', 'wineot_back_end_crud_winery_edit')
        ));
        $paramsRender = array('menu' => $crudMenu);
        return $this->render('WineotBackEndCRUDBundle:Default:index.html.twig', $paramsRender);
    }
}
