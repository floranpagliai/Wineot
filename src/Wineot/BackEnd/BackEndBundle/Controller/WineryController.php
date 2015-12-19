<?php
/**
 * User: floran
 * Date: 19/12/2015
 * Time: 09:56
 */

namespace Wineot\BackEnd\BackEndBundle\Controller;


use Doctrine\ODM\MongoDB\DocumentManager;
use MongoDBODMProxies\__CG__\Wineot\DataBundle\Document\Winery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WineryController  extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexOwningAction()
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();

        $wineries = $dm->getRepository('WineotDataBundle:Winery')->findBy(array('owning.is_verified' => false));
        $paramsRender = array('wineries' => $wineries);
        return $this->render('WineotBackEndBackEndBundle:Winery:index.html.twig', $paramsRender);
    }

    public function validateOwningAction(Request $request, $id)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        $flash = $this->get('notify_messenger.flash');

        $winery = $dm->getRepository('WineotDataBundle:Winery')->find($id);
        if ($winery) {
            $winery->getOwning()->setIsVerified(true);
            $dm->persist($winery);
            $dm->flush();

            $flash->success($this->get('translator')->trans('winery.warn.validate_owning'));
        }
        return $this->redirect($request->headers->get('referer'));
    }

    public function invalidateOwningAction(Request $request, $id)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        $flash = $this->get('notify_messenger.flash');

        $winery = $dm->getRepository('WineotDataBundle:Winery')->find($id);
        if ($winery) {
            $winery->setOwning(null);
            $dm->persist($winery);
            $dm->flush();

            $flash->success($this->get('translator')->trans('winery.warn.invalidate_owning'));
        }
        return $this->redirect($request->headers->get('referer'));
    }
}