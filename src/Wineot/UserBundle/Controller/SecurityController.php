<?php
/**
 * User: floran
 * Date: 08/11/14
 * Time: 14:04
 */

namespace Wineot\UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Wineot\DataBundle\Document\User;
use Wineot\UserBundle\Form\Type\UserType;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        if ($this->get('security.context')->isGranted('ROLE_USER'))
            return $this->redirect($this->generateUrl('wineot_user_profile'));
        $session = $request->getSession();
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        $lastUsername = (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);

        return $this->render('WineotUserBundle:Security:login.html.twig', array(
            // last username entered by the user
            'last_username' => $lastUsername,
            'error' => $error
        ));
    }

    public function loginCheckAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    public function registerAction(Request $request)
    {
        if ($this->get('security.context')->isGranted('ROLE_USER'))
            return $this->redirect($this->generateUrl('wineot_user_profile'));

        $em = $this->get('doctrine_mongodb')->getManager();

        $user = new User();
        $form = $this->createForm(new UserType(), $user);
        $errors = null;

        $form->handleRequest($request);
        if ($request->isMethod('POST')) {
            $validator = $this->get('validator');
            $errors = $validator->validate($user);
            if ($form->isValid()) {
                $encoder = $this->get('security.encoder_factory')->getEncoder($user);
                $user->setPassword($encoder->encodePassword($user->getPlainPassword(), null));

                $em->persist($user);
                $em->flush();

                $flash = $this->get('braincrafted_bootstrap.flash');
                $flash->success($this->get('translator')->trans('user.warn.can_login'));
                return $this->redirect($this->generateUrl('wineot_user_login'));
            }
        }
        $paramsRender = array('form' => $form->createView(), 'errors' => $errors);
        return $this->render('WineotUserBundle:Security:register.html.twig', $paramsRender);
    }

    public function profileAction()
    {
        if (!$this->get('security.context')->isGranted('ROLE_USER'))
            return $this->redirect($this->generateUrl('wineot_user_login'));
        return $this->render('WineotUserBundle:Security:profile.html.twig');
    }

    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
} 