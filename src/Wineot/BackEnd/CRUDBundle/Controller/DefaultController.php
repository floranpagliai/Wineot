<?php

namespace Wineot\BackEnd\CRUDBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN'))
            return $this->redirect($this->generateUrl('wineot_front_end_homepage'));
        return $this->render('WineotBackEndCRUDBundle:Default:index.html.twig');
    }
}
