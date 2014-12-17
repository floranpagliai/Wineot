<?php

namespace Wineot\FrontEnd\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

use Doctrine\ORM\EntityRepository;
use Wineot\FrontEnd\SearchBundle\Form\Type\SearchType;


class SearchController extends Controller
{
    public function searchAction(Request $request)
    {
        $form = $this->createForm(new SearchType());

        if ($request->isMethod('POST')) {
            $form->submit($request);
            if ($form->isValid()) {
                $searchInput = $form->getData()["searchInput"];
                $wineList = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('WineotDataBundle:Wine')
                    ->findBy(array('name' => $searchInput));
                if(!empty($wineList)){
                    // IL FAUT REDIRECT VERS UNE ACTION QUI VA RENDER A SON TOUR
                    return $this->render('WineotFrontEndSearchBundle:Search:SearchResult.html.twig', array('wineList' => $wineList));
                }
                else{
                    // AUCUN RESULTATS
                }
            }
        }

        return $this->render('WineotFrontEndSearchBundle:Search:Search.html.twig', array('form' => $form->createView()));
    }
}