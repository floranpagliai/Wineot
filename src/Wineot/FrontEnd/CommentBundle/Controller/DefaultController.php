<?php

namespace Wineot\FrontEnd\CommentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('WineotFrontEndCommentBundle:Default:index.html.twig', array('name' => $name));
    }
}
