<?php

namespace Wineot\FrontEnd\SearchBundle\Controller;

use Doctrine\ODM\MongoDB\Mapping\Annotations\Int;
use MongoRegex;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\FrontEnd\SearchBundle\Form\Type\SearchType;


class SearchController extends Controller
{
    public function searchAction()
    {
        $form = $this->createForm(new SearchType(), null,
            array(
                'action' => $this->generateUrl('wineot_search_result'),
                'method' => 'GET'));

        return $this->render('WineotFrontEndSearchBundle:Search:Search.html.twig', array('form' => $form->createView()));
    }

    public function searchResultAction(Request $request)
    {
        $form = $this->createForm(new SearchType());

        $wines = null;
        $wineries = null;
        $form->submit($request);
        if ($form->isValid()) {
            $searchInputs = explode(" ", $request->query->get('search')['searchInput']);
            $wineColor = $request->get('wineColor');

            $search = array();
            foreach ($searchInputs as $searchInput) {
                $search[] = new \MongoRegex("/$searchInput/i");
            }

            //Find wineries ids for the searched text
            $wineries = $this->get('doctrine_mongodb')->getRepository('WineotDataBundle:Winery')->search($search);
            $wines = $this->get('doctrine_mongodb')->getRepository('WineotDataBundle:Wine')->search($search, $wineColor, $wineries);
        }
        $paramsRender = array('wines' => $wines, 'wineries' => $wineries);
        return $this->render('WineotFrontEndSearchBundle:Search:SearchResult.html.twig', $paramsRender);

    }
}
