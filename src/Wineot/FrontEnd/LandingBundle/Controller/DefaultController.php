<?php

namespace Wineot\FrontEnd\LandingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $mc = $this->get('hype_mailchimp');
        $form = $this->createFormBuilder()
            ->add('email', 'email')
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $email = $form->getData()['email'];
            $mc->getList()->subscribe($email);
            return $this->redirect($this->generateUrl('wineot_front_end_landing_homepage'));
        }

        $paramsRender = array('form' => $form->createView());
        return $this->render('WineotFrontEndLandingBundle:Default:index.html.twig', $paramsRender);
    }
}
