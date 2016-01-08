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

    public function renderMenuAction($currentRoute)
    {
        $crudMenu = new ArrayCollection();

        $crudMenu->add(array(
            'route' => 'wineot_back_end_crud_winery',
            'name' => 'crud.title.wineries',
            'routes' => array('wineot_back_end_crud_winery', 'wineot_back_end_crud_winery_add', 'wineot_back_end_crud_winery_edit')
        ));
        $crudMenu->add(array(
            'route' => 'wineot_back_end_crud_wine',
            'name' => 'crud.title.wines',
            'routes' => array('wineot_back_end_crud_wine', 'wineot_back_end_crud_wine_add', 'wineot_back_end_crud_wine_edit')
        ));
        $crudMenu->add(array(
            'route' => 'wineot_back_end_crud_user',
            'name' => 'crud.title.users',
            'routes' => array('wineot_back_end_crud_user', 'wineot_back_end_crud_user_add', 'wineot_back_end_crud_user_edit')
        ));
        $crudMenu->add(array(
            'route' => 'wineot_back_end_crud_comment',
            'name' => 'crud.title.comments',
            'routes' => array('wineot_back_end_crud_comment', 'wineot_back_end_crud_comment_add', 'wineot_back_end_crud_comment_edit')
        ));
        $crudMenu->add(array(
            'route' => 'wineot_back_end_crud_country',
            'name' => 'crud.title.countries',
            'routes' => array('wineot_back_end_crud_country', 'wineot_back_end_crud_country_add', 'wineot_back_end_crud_country_edit')
        ));
        $crudMenu->add(array(
            'route' => 'wineot_back_end_crud_grappe',
            'name' => 'crud.title.grappes',
            'routes' => array('wineot_back_end_crud_grappe', 'wineot_back_end_crud_grappe_add', 'wineot_back_end_crud_grappe_edit')
        ));
        $paramsRender = array('menu' => $crudMenu, 'menuTitle' => 'CRUD', 'currentRoute' => $currentRoute);
        return $this->render('blocks/menu.html.twig', $paramsRender);
    }
}
