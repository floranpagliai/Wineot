<?php
/**
 * Created by PhpStorm.
 * User: flpag
 * Date: 03/11/15
 * Time: 14:39
 */

namespace Wineot\UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserRestController extends Controller
{
    public function getUserAction($username)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user =  $dm->getRepository('WineotDataBundle:User')->findOneByUsername($username);
        if(!is_object($user)){
            throw $this->createNotFoundException();
        }
        return $user;
    }

    public function getResetPasswordUserAction($email)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user =  $dm->getRepository('WineotDataBundle:User')->findOneByEmail($email);
        if(!is_object($user)){
            throw $this->createNotFoundException();
        }
        return true;
    }
}