<?php

namespace Wineot\FrontEnd\LandingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\FrontEnd\SearchBundle\Form\Type\SearchType;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $mailjet = $this->container->get('headoo_mailjet_wrapper');
        $flash = $this->get('notify_messenger.flash');

        $form = $this->createFormBuilder()
            ->add('email', 'email')
            ->getForm();
        $formSearch = $this->createForm(new SearchType(), null,
            array(
                'action' => $this->generateUrl('wineot_search_result'),
                'method' => 'GET'));

        $form->handleRequest($request);
        if ($form->isValid()) {
            $email = $form->getData()['email'];

            $params = array(
                "method" => "POST",
                "Email" => $email
            );
            $mailjet->contact($params);
//            if ($mailjet->_response_code == 200) {
                $params = array(
                    "method" => "POST",
                    "from" => "floran@wineot.net",
                    "to" => $email,
                    "subject" => "Que penses tu de Wine'ot",
                    "html" => $this->renderView('Emails/welcome.html.twig')
                );
                $mailjet->sendEmail($params);
                $flash->success($this->get('translator')->trans('landing.warn.success'));
//            } else
//                $flash->error($this->get('translator')->trans('landing.warn.error'));
            return $this->redirect($this->generateUrl('wineot_front_end_landing_homepage'));
        }

        $paramsRender = array('form' => $form->createView(), 'formSearch' => $formSearch->createView());
        return $this->render('WineotFrontEndLandingBundle:Default:index.html.twig', $paramsRender);
    }
}
