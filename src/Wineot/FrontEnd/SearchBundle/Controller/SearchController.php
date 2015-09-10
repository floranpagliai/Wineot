<?php

namespace Wineot\FrontEnd\SearchBundle\Controller;

use Doctrine\ODM\MongoDB\Mapping\Annotations\Int;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\FrontEnd\SearchBundle\Form\Type\SearchType;


class SearchController extends Controller
{
    public function searchAction(Request $request)
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
            $valueColor = $request->get('wineColor');

            $search = array();
            foreach ($searchInputs as $searchInput) {
                $search[] = new \MongoRegex("/$searchInput/i");
            }

            $dm = $this->get('doctrine_mongodb')->getManager();

            //Find wineries ids for the searched text
            $query = $dm->createQueryBuilder('WineotDataBundle:Winery');
            $wineries = $query
                ->field('name')->in($search)
                ->getQuery()->execute();
            $wineriesIds = array();
            foreach ($wineries as $winery)
                $wineriesIds[] = $winery->getId();

            //Find wines for the searched text or with the id of wineries found
            $query = $dm->createQueryBuilder('WineotDataBundle:Wine');
            $query
                ->addOr($query->expr()->field('name')->in($search))
                ->addOr($query->expr()->field('winery')->in($wineriesIds))
                ->sort('name', 'ASC');

            if ($valueColor != 3)
                $query->field('color')->equals(intval($valueColor));
            $wines = $query->getQuery()->execute();
        }
        $paramsRender = array('wines' => $wines, 'wineries' => $wineries);
        return $this->render('WineotFrontEndSearchBundle:Search:SearchResult.html.twig', $paramsRender);

    }
}
