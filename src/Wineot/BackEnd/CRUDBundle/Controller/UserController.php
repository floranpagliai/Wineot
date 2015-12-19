<?php
/**
 * User: floran
 * Date: 31/03/15
 * Time: 16:44
 */

namespace Wineot\BackEnd\CRUDBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\DataBundle\Form\UserEditCrudType;

class UserController extends Controller
{

    public function indexAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $users = $dm->getRepository('WineotDataBundle:User')->findAll();
        $paramsRender = array('users' => $users);
        return $this->render('WineotBackEndCRUDBundle:User:index.html.twig', $paramsRender);
    }

    public function editAction(Request $request, $id)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('WineotDataBundle:User')->find($id);
        if (!$user) {
            $flash->error($this->get('translator')->trans('crud.error.user.notfound'));
            return $this->redirectToRoute('wineot_back_end_crud_wine');
        }
        $form = $this->createForm(new UserEditCrudType(), $user);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dm->persist($user);
            $dm->flush();

            $flash->success($this->get('translator')->trans('user.warn.edited'));
            return $this->redirectToRoute('wineot_back_end_crud_user');
        }
        $paramsRender = array('form' => $form->createView(), 'id' => $id);
        return $this->render('WineotBackEndCRUDBundle:User:edit.html.twig', $paramsRender);
    }

    public function deleteAction($id)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $dm->getRepository('WineotDataBundle:user')->find($id);
        if ($user) {
            $dm->remove($user);
            $dm->flush();

            $flash->success($this->get('translator')->trans('user.warn.deleted'));
        } else {
            $flash->error($this->get('translator')->trans('crud.error.user.notfound'));
        }
        return $this->redirectToRoute('wineot_back_end_crud_user');
    }
} 