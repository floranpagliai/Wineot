<?php
/**
 * User: floran
 * Date: 31/03/15
 * Time: 16:44
 */

namespace Wineot\BackEnd\CRUDBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{

    public function indexAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $users = $dm->getRepository('WineotDataBundle:User')->findAll();
        $paramsRender = array('users' => $users);
        return $this->render('WineotBackEndCRUDBundle:User:index.html.twig', $paramsRender);
    }

    public function addAction()
    {

    }

    public function editAction()
    {

    }

    public function deleteAction($id)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('WineotDataBundle:user')->find($id);
        if ($user) {
            $dm->remove($user);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.user.deleted'));
        } else {
            $flash->error($this->get('translator')->trans('crud.error.user.notfound'));
        }
        return $this->redirectToRoute('wineot_back_end_crud_user');
    }
} 