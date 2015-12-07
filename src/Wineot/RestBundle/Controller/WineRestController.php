<?php
/**
 * User: floran
 * Date: 20/11/2015
 * Time: 21:08
 */

namespace Wineot\FrontEnd\WineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


class WineRestController extends Controller
{
    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get wine object for id",
     *  output="Wineot\DataBundle\Document\Wine",
     *  statusCodes={
     *         200="Returned when successful",
     *         404="Returned when the wine is not found"
     *  }
     * )
     *
     * @Get("/{id}")
     */
    public function getWineAction($id)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine =  $dm->getRepository('WineotDataBundle:Wine')->find($id);
        if(!is_object($wine)){
            throw $this->createNotFoundException();
        }

        return $wine;
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get vintage object for id",
     *  output="Wineot\DataBundle\Document\Vintage",
     *  statusCodes={
     *         200="Returned when successful",
     *         404="Returned when the vintage is not found"
     *  }
     * )
     *
     * @Get("/vintage/{id}")
     */
    public function getVintageAction($id)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine =  $dm->getRepository('WineotDataBundle:Vintage')->find($id);
        if(!is_object($wine)){
            throw $this->createNotFoundException();
        }

        return $wine;
    }
}