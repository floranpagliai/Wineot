<?php
/**
 * User: floran
 * Date: 16/11/2015
 * Time: 19:43
 */

namespace Wineot\UserBundle\Controller;


use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function renderMenuAction()
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
        $paramsRender = array('menu' => $crudMenu, 'menuTitle' => 'user.title.settings');
        return $this->render('WineotUserBundle:Default:menu.html.twig', $paramsRender);
    }
}