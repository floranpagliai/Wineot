<?php
/**
 * Created by PhpStorm.
 * User: flpag
 * Date: 03/11/15
 * Time: 14:39
 */

namespace Wineot\UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Response;

class UserRestController extends Controller
{
    /**
     * @Get("/{email}", requirements={"email"=".+"})
     * @Route(requirements={"email"=".+"})
     */
    public function getUserAction($email)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user =  $dm->getRepository('WineotDataBundle:User')->findOneBy(array('mail' => $email));
        if(!is_object($user)){
            throw $this->createNotFoundException();
        }
        $response = new Response();
        $response->setStatusCode(201);

        return $response;
    }

    /**
     * @Get("/password/reset/{mail}", requirements={"mail"=".+"})
     * @Route(requirements={"mail"=".+"})
     */
    public function getResetPasswordUserAction($mail)
    {
        $mailjet = $this->container->get('headoo_mailjet_wrapper');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user =  $dm->getRepository('WineotDataBundle:User')->findOneBy(array('mail' => $mail));
        if(!is_object($user)){
            throw $this->createNotFoundException("User not found");
        }
        $password =  substr(uniqid(rand(), true), 0, 8);
        $encoder = $this->get('security.encoder_factory')->getEncoder($user);
        $user->setPassword($encoder->encodePassword($password, null));
        $dm->persist($user);
        $dm->flush();

        $params = array(
            "method" => "POST",
            "from" => "no-reply@wineot.net",
            "to" => $user->getMail(),
            "subject" => $this->get('translator')->trans('user.title.password_reset'),
            "html" => $this->renderView('Emails/resetPassword.html.twig', array('password' => $password))
        );

        $mailjet->sendEmail($params);

        $response = new Response();
        $response->setStatusCode(201);

        return $response;
    }
}