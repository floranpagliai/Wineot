<?php
/**
 * User: floran
 * Date: 29/03/15
 * Time: 16:34
 */

namespace Wineot\BackEnd\CRUDBundle\Controller;

use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\DataBundle\Document\Vintage;
use Wineot\DataBundle\Document\Wine;
use Wineot\DataBundle\Form\WineType;

class WineController extends Controller
{
    public function indexAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wines = $dm->getRepository('WineotDataBundle:Wine')->findAll();
        $paramsRender = array('wines' => $wines);
        return $this->render('WineotBackEndCRUDBundle:Wine:index.html.twig', $paramsRender);
    }

    public function addAction(Request $request)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine = new Wine();
        $form = $this->createForm(new WineType(), $wine);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $dm->persist($wine);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.wine.added'));
            return $this->redirectToRoute('wineot_back_end_crud_wine');
        }

        $paramsRender = array('form' => $form->createView());
        return $this->render('WineotBackEndCRUDBundle:Wine:add.html.twig', $paramsRender);
    }

    public function editAction(Request $request, $id)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine = $dm->getRepository('WineotDataBundle:Wine')->find($id);
        if (!$wine) {
            $flash->error($this->get('translator')->trans('crud.error.wine.notfound'));
            return $this->redirectToRoute('wineot_back_end_crud_wine');
        }
        $form = $this->createForm(new WineType(), $wine);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dm->persist($wine);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.wine.edited'));
            return $this->redirectToRoute('wineot_back_end_crud_wine');
        }
        $paramsRender = array('form' => $form->createView(), 'id' => $id, 'wine' => $wine);
        return $this->render('WineotBackEndCRUDBundle:Wine:edit.html.twig', $paramsRender);
    }

    public function deleteAction($id)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine = $dm->getRepository('WineotDataBundle:Wine')->find($id);
        if ($wine) {
            $dm->remove($wine);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.wine.deleted'));
        } else {
            $flash->error($this->get('translator')->trans('crud.error.wine.notfound'));
        }
        return $this->redirectToRoute('wineot_back_end_crud_wine');
    }

    public function deletePictureAction($id)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine = $dm->getRepository('WineotDataBundle:Wine')->find($id);
        if ($wine) {
            $wine = new Wine();
            $picture = $wine->getLabelPicture();
            $dm->remove($picture);
            $wine->setLabelPicture(null);
            $dm->persist($wine);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.wine.picture.deleted'));
        } else {
            $flash->error($this->get('translator')->trans('crud.error.wine.notfound'));
        }
        return $this->redirectToRoute('wineot_back_end_crud_wine');
    }
} 