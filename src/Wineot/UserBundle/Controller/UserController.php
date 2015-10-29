<?php
/**
 * User: floran
 * Date: 11/10/15
 * Time: 13:23
 */

namespace Wineot\UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Util\SecureRandom;
use Wineot\DataBundle\Document\User;
use Wineot\DataBundle\Form\EmailType;
use Wineot\DataBundle\Form\UserEditPasswordType;
use Wineot\DataBundle\Form\UserEditType;
use Wineot\DataBundle\Form\UserType;

class UserController extends Controller
{
    public function profileAction()
    {
        if (!$this->get('security.context')->isGranted('ROLE_USER'))
            return $this->redirect($this->generateUrl('wineot_user_login'));

        $user = $this->getUser();
//        $favoritesWines = $user->getFavoritesWines();
        $favoritesWines = null;
//        $comments = $user->getComments();
        $paramsRender = array(
            'favoritesWines' => $favoritesWines
        );
        return $this->render('WineotUserBundle:User:profile.html.twig', $paramsRender);
    }

    public function editProfileAction(Request $request)
    {
        if (!$this->get('security.context')->isGranted('ROLE_USER'))
            return $this->redirect($this->generateUrl('wineot_user_login'));

        $em = $this->get('doctrine_mongodb')->getManager();

        $user = $this->getUser();
        $form = $this->createForm(new UserEditType(), $user);

        $form->handleRequest($request);
            if ($form->isValid()) {
                $em->persist($user);
                $em->flush();

                $flash = $this->get('notify_messenger.flash');
                $flash->success('user.warn.user_edited');
                return $this->redirect($this->generateUrl('wineot_user_profile'));
            }
        $paramsRender = array('form' => $form->createView());
        return $this->render('WineotUserBundle:Settings:editProfile.html.twig', $paramsRender);
    }

    public function editpasswordAction(Request $request)
    {
        if (!$this->get('security.context')->isGranted('ROLE_USER'))
            return $this->redirect($this->generateUrl('wineot_user_profile_edit'));

        $em = $this->get('doctrine_mongodb')->getManager();

        $user = $this->getUser();
        $form = $this->createForm(new UserEditPasswordType(), $user);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
            $user->setPassword($encoder->encodePassword($user->getPlainPassword(), null));
            $em->persist($user);
            $em->flush();

            $flash = $this->get('notify_messenger.flash');
            $flash->success($this->get('translator')->trans('user.warn.password_edited'));
            return $this->redirect($this->generateUrl('wineot_user_profile_edit_password'));
        }
        $paramsRender = array('form' => $form->createView());
        return $this->render('WineotUserBundle:Settings:editPassword.html.twig', $paramsRender);
    }

    /**
     *
     */
    public function resetPasswordAction(Request $request)
    {
        if ($this->get('security.context')->isGranted('ROLE_USER'))
            return $this->redirect($this->generateUrl('wineot_user_profile'));
        
        $em = $this->get('doctrine_mongodb')->getManager();
        $flash = $this->get('notify_messenger.flash');
        $mailjet = $this->container->get('headoo_mailjet_wrapper');
        $errors = null;

        $form = $this->createForm(new EmailType());

        $form->handleRequest($request);
        if ($form->isValid()) {
            $user = $em->getRepository('WineotDataBundle:User')->findOneBy(array('mail' => $form->get('mail')->getData()));
            if ($user) {

                $password =  substr(uniqid(rand(), true), 0, 8);
                $encoder = $this->get('security.encoder_factory')->getEncoder($user);
                $user->setPassword($encoder->encodePassword($password, null));
                $em->persist($user);
                $em->flush();

                $params = array(
                    "method" => "POST",
                    "from" => "no-reply@wineot.net",
                    "to" => $user->getMail(),
                    "subject" => $this->get('translator')->trans('user.title.reset_password'),
                    "html" => $this->renderView('Emails/resetPassword.html.twig', array('password' => $password))
                );

                $mailjet->sendEmail($params);

                $flash->success($this->get('translator')->trans('user.warn.reset_password'));
                return $this->redirect($this->generateUrl('wineot_user_login'));
            }
            $errors[] = array('message' => 'user.warn.unknown_email');
        }
        $paramsRender = array('form' => $form->createView(), 'errors' => $errors);
        return $this->render('WineotUserBundle:User:resetPassword.html.twig', $paramsRender);
    }

    public function favoriteAction(Request $request, $wineId)
    {
        $flash = $this->get('notify_messenger.flash');
        $user = $this->getUser();
        if (!$user) {
            $flash->error($this->get('translator')->trans('global.warn.usermostlogged'));
            return $this->redirect($request->headers->get('referer'));
        }
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine = $dm->getRepository('WineotDataBundle:Wine')->find($wineId);
        if ($wine) {
            $user->addFavoriteWine($wine);
            $flash->success($this->get('translator')->trans('wine.warn.favorited'));
            $dm->persist($user);
            $dm->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }

    public function unfavoriteAction(Request $request, $wineId)
    {
        $flash = $this->get('notify_messenger.flash');
        $user = $this->getUser();
        if (!$user) {
            $flash->error($this->get('translator')->trans('global.warn.usermostlogged'));
            return $this->redirect($request->headers->get('referer'));
        }
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine = $dm->getRepository('WineotDataBundle:Wine')->find($wineId);
        $user->removeFavoriteWine($wine);
        $flash->success($this->get('translator')->trans('wine.warn.unfavorited'));
        $dm->persist($user);
        $dm->flush();
        return $this->redirect($request->headers->get('referer'));
    }

}