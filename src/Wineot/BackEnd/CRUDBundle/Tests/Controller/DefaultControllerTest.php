<?php

namespace Wineot\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultControllerTest extends WebTestCase
{
    public function testCRUDPageDown()
    {
        $client = static::createClient();
        $session = $client->getContainer()->get('session');
        $firewall = 'main';
        $token = new UsernamePasswordToken('testUser', null, $firewall, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);

        $client->request('GET', '/admin/crud/');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET', '/admin/crud/wine/');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET', '/admin/crud/winery/');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET', '/admin/crud/comment/');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET', '/admin/crud/user/');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET', '/admin/crud/country/');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testCRUDFirewall()
    {
        $client = static::createClient();

        //Trying go to user route without being logged
        $client->request('GET', '/admin/crud/');
        $this->assertTrue($client->getResponse()->isRedirect());

        //Log a test user
        $session = $client->getContainer()->get('session');
        $firewall = 'main';
        $token = new UsernamePasswordToken('testUser', null, $firewall, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);

        //Trying go to user route being logged
        $client->request('GET', '/admin/crud/');
        $this->assertFalse($client->getResponse()->isRedirect());
    }
}