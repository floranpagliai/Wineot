<?php
/**
 * User: floran
 * Date: 13/06/15
 * Time: 18:51
 */

namespace Wineot\FrontEnd\WineBundle\Tests\Controller;

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

        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}