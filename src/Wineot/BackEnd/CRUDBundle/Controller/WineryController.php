<?php
/**
 * User: floran
 * Date: 31/03/15
 * Time: 18:28
 */

namespace Wineot\BackEnd\CRUDBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\DataBundle\Document\Winery;
use Wineot\DataBundle\Form\WineryType;

class WineryController extends Controller
{
    public function indexAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wineries = $dm->getRepository('WineotDataBundle:Winery')->findAll();
        $paramsRender = array('wineries' => $wineries);
        return $this->render('WineotBackEndCRUDBundle:Winery:index.html.twig', $paramsRender);
    }

    public function addAction(Request $request)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $winery = new Winery();
        $form = $this->createForm(new WineryType(), $winery);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $dm->persist($winery);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.winery.added'));
            return $this->redirectToRoute('wineot_back_end_crud_winery');
        }

        $paramsRender = array('form' => $form->createView());
        return $this->render('WineotBackEndCRUDBundle:Winery:add.html.twig', $paramsRender);
    }

    public function editAction(Request $request, $id)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $winery = $dm->getRepository('WineotDataBundle:Winery')->find($id);
        if (!$winery) {
            $flash->error($this->get('translator')->trans('crud.error.winery.notfound'));
            return $this->redirectToRoute('wineot_back_end_crud_wine');
        }
        $form = $this->createForm(new WineryType(), $winery);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dm->persist($winery);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.winery.edited'));
            return $this->redirectToRoute('wineot_back_end_crud_winery');
        }
        $paramsRender = array('form' => $form->createView(), 'id' => $id);
        return $this->render('WineotBackEndCRUDBundle:Winery:edit.html.twig', $paramsRender);
    }

    public function deleteAction($id)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $winery = $dm->getRepository('WineotDataBundle:Winery')->find($id);
        if ($winery) {
            $dm->remove($winery);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.winery.deleted'));
        } else {
            $flash->error($this->get('translator')->trans('crud.error.winery.notfound'));
        }
        return $this->redirectToRoute('wineot_back_end_crud_winery');
    }
} 