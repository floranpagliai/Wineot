<?php
/**
 * User: floran
 * Date: 18/05/15
 * Time: 17:55
 */

namespace Wineot\BackEnd\CRUDBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\DataBundle\Document\Country;
use Wineot\DataBundle\Form\CountryType;

class CountryController extends Controller
{
    public function indexAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $countries = $dm->getRepository('WineotDataBundle:Country')->findAll();
        $paramsRender = array('countries' => $countries);
        return $this->render('WineotBackEndCRUDBundle:Country:index.html.twig', $paramsRender);
    }

    public function addAction(Request $request)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $country = new Country();
        $form = $this->createForm(new CountryType(), $country);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $dm->persist($country);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.country.added'));
            return $this->redirectToRoute('wineot_back_end_crud_country');
        }

        $paramsRender = array('form' => $form->createView());
        return $this->render('WineotBackEndCRUDBundle:Country:add.html.twig', $paramsRender);
    }

    public function editAction(Request $request, $id)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $country = $dm->getRepository('WineotDataBundle:Country')->find($id);
        if (!$country) {
            $flash->error($this->get('translator')->trans('crud.error.country.notfound'));
            return $this->redirectToRoute('wineot_back_end_crud_country');
        }
        $form = $this->createForm(new CountryType(), $country);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dm->persist($country);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.country.edited'));
            return $this->redirectToRoute('wineot_back_end_crud_country');
        }
        $paramsRender = array('form' => $form->createView(), 'id' => $id, 'country' => $country);
        return $this->render('WineotBackEndCRUDBundle:Country:edit.html.twig', $paramsRender);
    }

    public function deleteAction($id)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $country = $dm->getRepository('WineotDataBundle:Country')->find($id);
        if ($country) {
            $dm->remove($country);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.country.deleted'));
        } else {
            $flash->error($this->get('translator')->trans('crud.error.country.notfound'));
        }
        return $this->redirectToRoute('wineot_back_end_crud_country');
    }
} 