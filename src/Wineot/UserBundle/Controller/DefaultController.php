<?php
/**
 * User: floran
 * Date: 16/11/2015
 * Time: 19:43
 */

namespace Wineot\UserBundle\Controller;


use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function renderMenuAction($currentRoute)
    {
        $crudMenu = new ArrayCollection();

        $crudMenu->add(array(
            'route' => 'wineot_user_profile_edit',
            'name' => 'user.title.my_informations',
            'routes' => ['wineot_user_profile_edit']
        ));
        $crudMenu->add(array(
            'route' => 'wineot_user_profile_edit_password',
            'name' => 'user.title.password_edit',
            'routes' => ['wineot_user_profile_edit_password']
        ));
        $paramsRender = array('menu' => $crudMenu, 'menuTitle' => 'user.title.settings', 'currentRoute' => $currentRoute);
        return $this->render('blocks/menu.html.twig', $paramsRender);
    }
}