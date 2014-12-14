<?php

namespace Wineot\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

use  Doctrine\ORM\EntityRepository;
use Wineot\SearchBundle\Entity\Vin;
use Wineot\SearchBundle\Form\Type\SearchType;


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
                    return $this->render('WineotSearchBundle:Search:SearchResult.html.twig', array('wineList' => $wineList));
                }
                else{
                    // AUCUN RESULTATS
                }
            }
        }

        return $this->render('WineotSearchBundle:Search:Search.html.twig', array('form' => $form->createView()));
    }




    /* $paramRender = array('form' => $form->createView(),
 'vinList' => $vinList);*/

    /* public function FormAction(){
         $form = $this->createForm(new SearchType());
         return $this->render('WineotSearchBundle:Search:Search.html.twig', array('form'=> $form->createView()));
     }*/
}