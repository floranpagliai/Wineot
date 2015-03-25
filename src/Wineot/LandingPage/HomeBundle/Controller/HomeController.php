<?php
/**
 * User: floran
 * Date: 06/03/15
 * Time: 11:29
 */

namespace Wineot\LandingPage\HomeBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller {

    public function indexAction()
    {
        return $this->render('WineotLandingPageHomeBundle:home:index.html.twig');
    }

} 