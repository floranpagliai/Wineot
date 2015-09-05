<?php

namespace Wineot\FrontEnd\WineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\DataBundle\Document\User;

class WineController extends Controller
{
    public function showAction($wineName, $wineId, $vintage)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine = $dm->getRepository('WineotDataBundle:Wine')->find($wineId);
        $paramsRender = array('wine' => $wine, 'vintage' => $vintage);
        return $this->render('WineotFrontEndWineBundle:Wine:show.html.twig', $paramsRender);
    }

    public function trendsAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wines = $dm->getRepository('WineotDataBundle:Wine')->findTrendingWines();
        $paramsRender = array('wines' => $wines, 'wineListTitle' => 'wine.title.trends');
        return $this->render('WineotFrontEndWineBundle:Wine:list.html.twig', $paramsRender);
    }

    public function favoriteAction(Request $request, $wineId)
    {
        $flash = $this->get('notify_messenger.flash');
        $user = $this->getUser();
        if (!$user) {
            $flash->error($this->get('translator')->trans('comment.warn.usermostlogged'));
            return $this->redirect($request->headers->get('referer'));
        }
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine = $dm->getRepository('WineotDataBundle:Wine')->find($wineId);
        $user->addFavoriteWine($wine);
        $flash->success($this->get('translator')->trans('comment.warn.favorited'));
        $dm->persist($user);
        $dm->flush();
        return $this->redirect($request->headers->get('referer'));
    }

    public function unfavoriteAction(Request $request, $wineId)
    {
        $flash = $this->get('notify_messenger.flash');
        $user = $this->getUser();
        if (!$user) {
            $flash->error($this->get('translator')->trans('comment.warn.usermostlogged'));
            return $this->redirect($request->headers->get('referer'));
        }
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine = $dm->getRepository('WineotDataBundle:Wine')->find($wineId);
        $user->removeFavoriteWine($wine);
        $flash->success($this->get('translator')->trans('comment.warn.unfavorited'));
        $dm->persist($user);
        $dm->flush();
        return $this->redirect($request->headers->get('referer'));
    }
}
