<?php

namespace Wineot\FrontEnd\HomeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontEndControllerTest extends WebTestCase
{
    public function testHomePageDown()
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}
