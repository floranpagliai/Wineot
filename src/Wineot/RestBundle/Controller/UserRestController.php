<?php
/**
 * Created by PhpStorm.
 * User: flpag
 * Date: 03/11/15
 * Time: 14:39
 */

namespace Wineot\RestBundle\Controller;


use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Get;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Wineot\DataBundle\Document\User;

class UserRestController extends Controller
{
    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get user object for mail",
     *  output="Wineot\DataBundle\Document\User",
     *  statusCodes={
     *         200="Returned when successful",
     *         404="Returned when the user is not found"
     *  }
     * )
     *
     * @Get("/{mail}")
     */
    public function getUserAction($mail)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user =  $dm->getRepository('WineotDataBundle:User')->findOneBy(array('mail' => $mail));
        if(!is_object($user)){
            throw $this->createNotFoundException("User not found");
        }
        $response = new Response();
        $response->setStatusCode(200);

        return $user;
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Reset user password for mail, a mail will be sent to him.",
     *  statusCodes={
     *         200="Returned when successful",
     *         404="Returned when the user is not found"
     *  }
     * )
     *
     * @Get("/{mail}/resetpassword")
     * @param $mail
     *
     * @return Response
     */
    public function getResetPasswordUserAction($mail)
    {
        $mailjet = $this->container->get('headoo_mailjet_wrapper');
        /* @var $dm DocumentManager */
        $dm = $this->get('doctrine_mongodb')->getManager();
        /* @var $user User */
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
            "to" => $user->getUsername(),
            "subject" => $this->get('translator')->trans('user.title.password_forget'),
            "html" => $this->renderView('Emails/resetPassword.html.twig', array('password' => $password))
        );

        $mailjet->sendEmail($params);

        $response = new Response();
        $response->setStatusCode(200);

        return $response;
    }
}