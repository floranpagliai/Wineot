<?php
/**
 * User: floran
 * Date: 13/06/15
 * Time: 22:26
 */

namespace Wineot\FrontEnd\WineryBundle\Controller;

use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\DataBundle\Document\Owning;
use Wineot\DataBundle\Document\Winery;

class WineryController extends Controller
{
    public function showAction($wineryId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $winery = $dm->getRepository('WineotDataBundle:Winery')->find($wineryId);
        if (!$winery)
            throw $this->createNotFoundException('winery.warn.doesntexsit');
        return $this->render('WineotFrontEndWineryBundle:Winery:show.html.twig', array('winery' => $winery));
    }

    public function listWineAction($wineryId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $winery = $dm->getRepository('WineotDataBundle:Winery')->find($wineryId);
        if (!$winery)
            throw $this->createNotFoundException('winery.warn.doesntexsit');
        $wines = $winery->getWines();
        $paramsRender = array('wines' => $wines, 'wineListTitle' => 'winery.title.wines_list');
        return $this->render('WineotFrontEndWineBundle:Wine:list.html.twig', $paramsRender);
    }

    public function ownAction(Request $request, $wineryId)
    {
        $flash = $this->get('notify_messenger.flash');

        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $this->getUser();

        /** @var Winery $winery*/
        $winery = $dm->getRepository('WineotDataBundle:Winery')->find($wineryId);
        if (!$winery)
            throw $this->createNotFoundException('winery.warn.doesntexsit');
        if ($user) {
            $owning = new Owning();
            $owning->setUser($user);
            $winery->setOwning($owning);
            $dm->persist($winery);
            $dm->flush();
            $flash->success($this->get('translator')->trans('winery.warn.request_owning'));
        } else
            $flash->error($this->get('translator')->trans('user.warn.must_logged'));

        return $this->redirect($request->headers->get('referer'));
    }

    public function bestRatedAction($wineryId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wines = $dm->getRepository('WineotDataBundle:Wine')->findBestRatedWines($wineryId);
        if (is_array($wines))
            $paramsRender = array('wines' => $wines, 'wineListTitle' => 'winery.title.wines_list');
        else
            return $this->redirect($this->generateUrl('wineot_front_end_wine_best_rated'));
        return $this->render('WineotFrontEndWineBundle:Wine:list.html.twig', $paramsRender);
    }
} 