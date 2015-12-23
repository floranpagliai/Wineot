<?php
/**
 * User: floran
 * Date: 13/06/15
 * Time: 18:51
 */

namespace Wineot\FrontEnd\WineBundle\Tests\Controller;

use MongoDBODMProxies\__CG__\Wineot\DataBundle\Document\Vintage;
use MongoDBODMProxies\__CG__\Wineot\DataBundle\Document\Wine;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WineControllerTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $dm;

    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->dm = static::$kernel->getContainer()->get('doctrine_mongodb')->getManager();
    }

    public function testWinePageDown()
    {
        $client = static::createClient();


        $vintages = $this->dm->getRepository('WineotDataBundle:Vintage')->createQueryBuilder('v')->limit(15)->getQuery()->execute();
        foreach ($vintages as $vintage)
        {
            /** @var Vintage $vintage */
            $wineryName = $vintage->getWinery()->getName();
            $wineName = $vintage->getWine()->getName();
            $vintageYear = $vintage->getProductionYear();
            $vintageId = $vintage->getId();
            $client->request('GET', '/winery/'.$wineryName.'/wine/'.$wineName.'/'.$vintageYear.'/'.$vintageId);
            $this->assertTrue($client->getResponse()->isSuccessful());
        }

    }
}