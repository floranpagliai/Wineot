<?php

namespace Wineot\BackEnd\BackEndBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class BackEndControllerTest extends WebTestCase
{
    public function testBackEndPageDown()
    {
        $client = static::createClient();

        $client->request('GET', '/admin');
        $this->assertTrue($client->getResponse()->isRedirect());
    }

    public function testBackEndFirewall()
    {
        $client = static::createClient();

        //Trying go to user route without being admin
        $client->request('GET', '/admin');
        $this->assertTrue($client->getResponse()->isRedirect());

        //Log a test user
        $session = $client->getContainer()->get('session');
        $firewall = 'main';
        $token = new UsernamePasswordToken('testUser', null, $firewall, array('ROLE_USER'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);

        //Trying go to user route being logged
        $client->request('GET', '/admin');
        $this->assertTrue($client->getResponse()->isRedirect());
    }
}
