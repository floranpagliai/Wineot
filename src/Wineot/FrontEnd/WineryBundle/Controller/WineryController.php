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
use Wineot\DataBundle\Document\User;
use Wineot\DataBundle\Document\Winery;
use Wineot\DataBundle\Form\WineryType;

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

    public function editAction(Request $request, $wineryId)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $flash = $this->get('notify_messenger.flash');
        $winery = $dm->getRepository('WineotDataBundle:Winery')->find($wineryId);
        if (!$winery) {
            $flash->error($this->get('translator')->trans('crud.error.winery.notfound'));
            return $this->redirect($request->headers->get('referer'));
        }
        $form = $this->createForm(new WineryType(), $winery);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dm->persist($winery);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.winery.edited'));
            return $this->redirectToRoute('wineot_user_profile');
        }
        $paramsRender = array('form' => $form->createView(), 'id' => $wineryId, 'winery' => $winery);
        return $this->render('WineotFrontEndWineryBundle:Winery:edit.html.twig', $paramsRender);
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
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        $flash = $this->get('notify_messenger.flash');
        $mailjet = $this->container->get('headoo_mailjet_wrapper');
        $user = $this->getUser();

        /** @var Winery $winery*/
        $winery = $dm->getRepository('WineotDataBundle:Winery')->find($wineryId);
        if (!$winery)
            throw $this->createNotFoundException('winery.warn.doesntexsit');
        if ($user) {
            $owning = new Owning();
            $owning->setUser($user);
            $winery->setOwning($owning);

            $params = array(
                "method" => "POST",
                "from" => "floran@wineot.net",
                "to" => $user->getUsername(),
                "subject" => $this->get('translator')->trans('winery.title.owning'),
                "html" => $this->renderView('Emails/owning.html.twig', array('wineryName' => $winery->getName()))
            );
            $mailjet->sendEmail($params);

            $dm->persist($winery);
            $dm->flush();
            $flash->success($this->get('translator')->trans('winery.warn.request_owning'));
        } else
            $flash->error($this->get('translator')->trans('user.warn.must_logged'));

        return $this->redirect($request->headers->get('referer'));
    }

    public function listOwningAction(Request $request)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $ownings = $dm->getRepository('WineotDataBundle:Winery')->getOwnings($this->getUser()->getId());
        $paramsRender = array('ownings' => $ownings);
        return $this->render('WineotFrontEndWineryBundle:Winery:list.html.twig', $paramsRender);
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