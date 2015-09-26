<?php
/**
 * User: floran
 * Date: 12/09/15
 * Time: 14:26
 */

namespace Wineot\BackEnd\CRUDBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\DataBundle\Document\Grappe;
use Wineot\DataBundle\Form\GrappeType;

class GrappeController extends Controller
{
    public function indexAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wines = $dm->getRepository('WineotDataBundle:Grappe')->findAll();
        $paramsRender = array('grappes' => $wines);
        return $this->render('WineotBackEndCRUDBundle:Grappe:index.html.twig', $paramsRender);
    }

    public function addAction(Request $request)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $grappe = new Grappe();
        $form = $this->createForm(new GrappeType(), $grappe);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $dm->persist($grappe);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.grappe.added'));
            return $this->redirectToRoute('wineot_back_end_crud_grappe');
        }

        $paramsRender = array('form' => $form->createView());
        return $this->render('WineotBackEndCRUDBundle:Grappe:add.html.twig', $paramsRender);
    }

    public function editAction(Request $request, $id)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $grappe = $dm->getRepository('WineotDataBundle:Grappe')->find($id);
        if (!$grappe) {
            $flash->error($this->get('translator')->trans('crud.error.grappe.notfound'));
            return $this->redirectToRoute('wineot_back_end_crud_grappe');
        }

        $form = $this->createForm(new GrappeType(), $grappe);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dm->persist($grappe);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.grappe.edited'));
            return $this->redirectToRoute('wineot_back_end_crud_grappe');
        }
        $paramsRender = array('form' => $form->createView(), 'id' => $id, 'grappe' => $grappe);
        return $this->render('WineotBackEndCRUDBundle:Grappe:edit.html.twig', $paramsRender);
    }

    public function deleteAction($id)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine = $dm->getRepository('WineotDataBundle:Grappe')->find($id);
        if ($wine) {
            $dm->remove($wine);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.grappe.deleted'));
        } else {
            $flash->error($this->get('translator')->trans('crud.error.grappe.notfound'));
        }
        return $this->redirectToRoute('wineot_back_end_crud_grappe');
    }
} 