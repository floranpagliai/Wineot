<?php
/**
 * Created by PhpStorm.
 * User: laurent
 * Date: 03/12/2015
 * Time: 14:41
 */

namespace Wineot\BackEnd\BackEndBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Wineot\DataBundle\Document\Wine;

class WineController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN'))
            return $this->redirect($this->generateUrl('wineot_front_end_homepage'));

        $dm = $this->get('doctrine_mongodb')->getManager();
        $wines = $dm->getRepository('WineotDataBundle:Wine')->findBy(array('isVerified'=>false));
        $paramsRender = array('wines' => $wines);
        return $this->render('WineotBackEndBackEndBundle:Wine:index.html.twig', $paramsRender);
    }

    public function validateAction($id)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine = $dm->getRepository('WineotDataBundle:Wine')->find($id);
        if (!$wine)
            $flash->error($this->get('translator')->trans('crud.error.wine.notfound'));
        else
        {
            $wine->setIsVerified(true);
            $dm->persist($wine);
            $dm->flush();
            $flash->success($this->get('translator')->trans('crud.warn.wine.validated'));
        }
        return $this->redirectToRoute('wineot_back_end_admin_wine');
    }
}