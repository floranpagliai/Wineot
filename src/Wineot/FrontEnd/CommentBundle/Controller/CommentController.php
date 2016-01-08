<?php
/**
 * User: floran
 * Date: 30/05/15
 * Time: 12:41
 */

namespace Wineot\FrontEnd\CommentBundle\Controller;

use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\DataBundle\Document\Comment;
use Wineot\DataBundle\Document\Vintage;
use Wineot\DataBundle\Form\CommentType;

class CommentController extends Controller
{
    public function listAction(Request $request, $wine)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
//        $wine = $dm->getRepository('WineotDataBundle:Wine')->findBy($wineId);
        $comments = $wine->getComments();
//        if ($wine)
//            $comments = $wine->getComments();
//        else
//            $comments = $dm->getRepository('WineotDataBundle:Comment')->findBy(array('wine' => $wineId));
        $paramsRender = array('comments' => $comments);
        return $this->render('WineotFrontEndCommentBundle:Comment:list.html.twig', $paramsRender);
    }

    public function addAction(Request $request, $vintageId)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        $user = $this->getUser();
        $flash = $this->get('notify_messenger.flash');


        /** @var Vintage $vintage */
        $vintage = $dm->getRepository('WineotDataBundle:Vintage')->find($vintageId);

        $form = $this->createForm(new CommentType());
        $form->submit($request);
        if ($user) {
            if ($form->isValid()) {
                /** @var Comment $comment */
                $comment = $form->getData();
                $comment->setWine($vintage);
                $comment->setUser($user);

                $dm->persist($comment);
                $dm->flush();

                //update average rating for the commented wine
                $dm->getRepository('WineotDataBundle:Wine')->calculateAvgRating($vintage->getWine()->getId());

                $flash->success($this->get('translator')->trans('comment.warn.added'));
            }
        } else {
            $flash->error($this->get('translator')->trans('user.warn.must_logged'));
        }

        return $this->redirect($request->headers->get('referer'));
    }

    public function getAddFormAction($vintageId)
    {
        $form = $this->createForm(new CommentType(), new Comment(),
            array(
                'action' => $this->generateUrl('wineot_front_end_comment_add', array('vintageId' => $vintageId))
            ));
        $paramsRender = array('form' => $form->createView());
        return $this->render('WineotFrontEndCommentBundle:Comment:add.html.twig', $paramsRender);
    }
} 