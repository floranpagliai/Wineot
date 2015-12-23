<?php

namespace Wineot\FrontEnd\SearchBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use MongoRegex;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\DataBundle\Document\Wine;
use Wineot\FrontEnd\SearchBundle\Form\Type\SearchType;
use Wineot\FrontEnd\SearchBundle\Resources\utils\StringUtil;


class SearchController extends Controller
{
    public function searchAction(Request $request)
    {
        $form = $this->createForm(new SearchType(), null,
            array(
                'action' => $this->generateUrl('wineot_search_result'),
                'method' => 'GET'));
        $searchInput = $request->query->get('search')['searchInput'];
        $paramsRender = array('form' => $form->createView(), 'searchInput' => $searchInput);
        return $this->render('WineotFrontEndSearchBundle:Search:Search.html.twig', $paramsRender);
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
                $searchInput = StringUtil::accentToRegex($searchInput);
                $search[] = new \MongoRegex("/$searchInput/i");
            }

            //Find wineries ids for the searched text
            $wineries = $this->get('doctrine_mongodb')->getRepository('WineotDataBundle:Winery')->search($search);
            //Find wines for the matched wineries or for the searched text
            $wines = $this->get('doctrine_mongodb')->getRepository('WineotDataBundle:Wine')->search($search, $wineColor, $wineries);

            //Order wines by counting the words who matchs
            if (sizeof($wines) > 0)
            {
                /** @var Wine $wine */
                foreach ($wines as $wine)
                {
                    $count = 0;
                    foreach ($searchInputs as $searchInput)
                    {
                        $searchInput = StringUtil::sanitize($searchInput);
                        if (stripos(StringUtil::sanitize($wine->getName()), $searchInput) !== false || stripos(StringUtil::sanitize($wine->getWinery()->getName()), $searchInput) !== false)
                            $count++;
                    }
                    $orderWines[] = array('count' => $count, 'wine' => $wine);
                }
                usort($orderWines, function($a, $b) { return $a['count'] - $b['count']; });
                $orderWines = array_reverse($orderWines);
                $wines = null;
                foreach ($orderWines as $orderWine)
                    $wines[] = $orderWine['wine'];
            }
        }
        $paramsRender = array('wines' => $wines, 'wineries' => $wineries);
        return $this->render('WineotFrontEndSearchBundle:Search:SearchResult.html.twig', $paramsRender);

    }
}
