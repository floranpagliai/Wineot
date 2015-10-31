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
        $wine = $dm->getRepository('WineotDataBundle:Vintage')->find($vintageId);
        $comment = new Comment();
        $form = $this->createForm(new CommentType(), $comment);
        $userComment = null;

        $comment->setWine($wine);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            if ($user) {
                if ($form->isValid() && !isset($userComment)) {
                    $comment->setUser($user);
                    $dm->persist($comment);
                    $dm->flush();

                    $flash->success($this->get('translator')->trans('comment.warn.added'));
                }
                $userComment = $dm->getRepository('WineotDataBundle:Comment')->findOneBy(array('wine' => $wine->getId(), 'user' => $user->getId()));
            } else {
                $flash->error($this->get('translator')->trans('comment.warn.usermostlogged'));
            }
        }

        $paramsRender = array('form' => $form->createView(), 'userComment' => $userComment);
        return $this->render('WineotFrontEndCommentBundle:Comment:add.html.twig', $paramsRender);
    }
} 