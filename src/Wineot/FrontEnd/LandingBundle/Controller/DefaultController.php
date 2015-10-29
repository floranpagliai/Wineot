<?php

namespace Wineot\FrontEnd\LandingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $mc = $this->get('hype_mailchimp');
        $mailjet = $this->container->get('headoo_mailjet_wrapper');
        $flash = $this->get('notify_messenger.flash');

        $form = $this->createFormBuilder()
            ->add('email', 'email')
            ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $email = $form->getData()['email'];
//            $mc->getList()->subscribe($email);
            $params = array(
                "method" => "POST",
                "from" => "floran@wineot.net",
                "to" => $email,
                "subject" => "Que penses tu de Wine'ot",
                "html" => $this->renderView('Emails/welcome.html.twig')
            );
            $mailjet->sendEmail($params);

            $params = array(
                "method" => "POST",
                "ListID" => 1519070,
                "Email" => $email
            );
            $mailjet->contact($params);
            $flash->success($this->get('translator')->trans('landing.warn.success'));
            return $this->redirect($this->generateUrl('wineot_front_end_landing_homepage'));
        }

        $paramsRender = array('form' => $form->createView());
        return $this->render('WineotFrontEndLandingBundle:Default:index.html.twig', $paramsRender);
    }
}
