<?php
/**
 * User: floran
 * Date: 30/05/15
 * Time: 12:41
 */

namespace Wineot\FrontEnd\CommentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\DataBundle\Document\Comment;
use Wineot\DataBundle\Form\CommentType;

class CommentController extends Controller
{
    public function listAction(Request $request, $wine)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $comments = $dm->getRepository('WineotDataBundle:Comment')->findBy(array('wine' => $wine->getId()));
        $paramsRender = array('comments' => $comments);
        return $this->render('WineotFrontEndCommentBundle:Comment:list.html.twig', $paramsRender);
    }

    public function addAction(Request $request, $wine)
    {
        $user = $this->getUser();
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $comment = new Comment();
        $comment->setWine($wine);
        $form = $this->createForm(new CommentType(), $comment);
        $form->handleRequest($request);
        if ($request->isMethod('POST')) {
            if ($user) {
                if ($form->isValid()) {
                    $comment->setUser($user);
                    $dm->persist($comment);
                    $dm->flush();

                    $flash->success($this->get('translator')->trans('comment.warn.added'));
                }
            } else {
                $flash->error($this->get('translator')->trans('comment.warn.usermostlogged'));
            }
        }

        $paramsRender = array('form' => $form->createView());
        return $this->render('WineotFrontEndCommentBundle:Comment:add.html.twig', $paramsRender);
    }
} 