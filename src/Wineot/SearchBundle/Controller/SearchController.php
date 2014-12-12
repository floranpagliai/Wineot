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
        $vinList = '';
        echo "<script>alert(\"Fonction\")</script>";
        $form = $this->createForm(new SearchType());


       //if($request->isMethod('POST')){
        if ($form->isValid()) {
            $vinRecherche = $form->getName();
            echo "<script>alert(\"POST\")</script>";
            $vinList = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('WineotSearchBundle:vin')
                ->findBy(array('name' => $vinRecherche));
          if(!empty($vinList)){
            createArticle($vinList);
          }
           else{
               // AUCUN RESULTATS
           }
        }

        return $this->render('WineotSearchBundle:Search:Search.html.twig', array('form' =>$form->createView()));
    }

    public function createArticle($vinList){
        return $this->render('WineotSearchBundle:Search:ResultSearch.html.twig', array('vinList' =>$vinList));
    }




    /* $paramRender = array('form' => $form->createView(),
 'vinList' => $vinList);*/

   /* public function FormAction(){
        $form = $this->createForm(new SearchType());
        return $this->render('WineotSearchBundle:Search:Search.html.twig', array('form'=> $form->createView()));
    }*/
}