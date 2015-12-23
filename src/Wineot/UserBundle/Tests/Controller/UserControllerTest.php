<?php
/**
 * User: floran
 * Date: 19/11/14
 * Time: 09:15
 */

namespace Wineot\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserControllerTest extends WebTestCase
{
    public function testUserPageDown()
    {
        $client = static::createClient();

        //Log a test user
        $session = $client->getContainer()->get('session');
        $firewall = 'main';
        $token = new UsernamePasswordToken('testUser', null, $firewall, array('ROLE_USER'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);

        //Trying go to user route being logged
        $client->request('GET', '/user/profile');
        $this->assertFalse($client->getResponse()->isRedirect());

        $client->request('GET', '/user/profile/edit');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET', '/user/profile/editpassword');
        $this->assertFalse($client->getResponse()->isSuccessful());
        
    }

}