<?php

namespace Wineot\FrontEnd\WineBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\DataBundle\Document\User;
use Wineot\DataBundle\Document\Vintage;
use Wineot\DataBundle\Document\Wine;
use Wineot\DataBundle\Form\WineType;

class WineController extends Controller
{
    public function redirectWineAction($wineryName, $wineName, $wineId)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        $vintage = $dm->getRepository('WineotDataBundle:Vintage')->getNewest($wineId);
        if (!$vintage)
            throw $this->createNotFoundException('wine.warn.notfound');
        $params = array(
            'wineryName' => $wineryName,
            'wineName' => $wineName,
            'vintage' => $vintage->getProductionYear(),
            'vintageId' => $vintage->getId());
        return $this->redirect($this->generateUrl('wineot_front_end_wine_show', $params));
    }

    public function showAction($vintageId)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        $vintage = $dm->getRepository('WineotDataBundle:Vintage')->find($vintageId);
        if (!$vintage)
            throw $this->createNotFoundException('wine.warn.notfound');
        $wine = $vintage->getWine();
        $timeline = null;
        if ($vintage->getKeeping() || $vintage->getPeak()) {
            $productionYear =  array(
                'title' => 'wine.title.vintage',
                'date' => array('year' => $vintage->getProductionYear())
            );
            $timeline[] = $productionYear;
            if ($vintage->getPeak())
                $timeline[] = array(
                    'title' => 'wine.title.keeping',
                    'date' => array('year' => $vintage->getPeak())
                );
            if ($vintage->getKeeping())
                $timeline[] = array(
                    'title' => 'wine.title.keeping',
                    'date' => array('year' => $vintage->getKeeping())
                );
        }

        $paramsRender = array('wine' => $wine, 'vintage' => $vintage, 'timeline' => $timeline);
        return $this->render('WineotFrontEndWineBundle:Vintage:show.html.twig', $paramsRender);
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
            return $this->redirect($request->headers->get('referer'));
        }

        $paramsRender = array('form' => $form->createView());
        return $this->render('WineotFrontEndWineBundle:Wine:add.html.twig', $paramsRender);
    }

    public function editAction(Request $request, $wineId)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine = $dm->getRepository('WineotDataBundle:Wine')->find($wineId);
        if (!$wine) {
            $flash->error($this->get('translator')->trans('crud.error.wine.notfound'));
            return $this->redirect($request->headers->get('referer'));
        }

        $originalVintages = new ArrayCollection();
        foreach ($wine->getVintages() as $vintage) {
            $originalVintages->add($vintage);
        }

        $originalGrappes = new ArrayCollection();
        foreach ($wine->getGrappes() as $grappe) {
            $originalGrappes->add($grappe);
        }

        $form = $this->createForm(new WineType(), $wine);
        $form->handleRequest($request);
        if ($form->isValid()) {

            foreach ($originalVintages as $vintage) {
                if ($wine->getVintages()->contains($vintage) == false) {
                    $dm->remove($vintage);
                }
            }
            foreach ($originalGrappes as $grappe) {
                if ($wine->getGrappes()->contains($grappe) == false) {
                    $dm->remove($grappe);
                }
            }
            $dm->persist($wine);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.wine.edited'));
            return $this->redirect($request->headers->get('referer'));
        }
        $paramsRender = array('form' => $form->createView());
        return $this->render('WineotFrontEndWineBundle:Wine:edit.html.twig', $paramsRender);
    }

    public function trendsAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wines = $dm->getRepository('WineotDataBundle:Wine')->findTrendingWines();
        $paramsRender = array('wines' => $wines, 'wineListTitle' => 'wine.title.trends');
        return $this->render('WineotFrontEndWineBundle:Wine:list.html.twig', $paramsRender);
    }

    public function bestRatedAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wines = $dm->getRepository('WineotDataBundle:Wine')->findBestRatedWines();
        $paramsRender = array('wines' => $wines, 'wineListTitle' => 'wine.title.best_rated');
        return $this->render('WineotFrontEndWineBundle:Wine:list.html.twig', $paramsRender);
    }
}
