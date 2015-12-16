<?php
/**
 * User: floran
 * Date: 30/05/15
 * Time: 12:41
 */

namespace Wineot\FrontEnd\CommentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Wineot\DataBundle\Document\Comment;
use Wineot\DataBundle\Document\Wine;
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
        $user = $this->getUser();
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();

        $vintage = $dm->getRepository('WineotDataBundle:Vintage')->find($vintageId);
        $comment = new Comment();
        $form = $this->createForm(new CommentType(), $comment);

        $comment->setWine($vintage);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            if ($user) {
                if ($form->isValid()) {
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
        }

        $paramsRender = array('form' => $form->createView());
        return $this->render('WineotFrontEndCommentBundle:Comment:add.html.twig', $paramsRender);
    }
} 