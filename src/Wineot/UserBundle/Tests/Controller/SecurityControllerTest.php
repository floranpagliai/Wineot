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

class SecurityControllerTest extends WebTestCase {
    public function testLogin()
    {
        $client = static::createClient();

        //Trying go to user route without being logged
        $client->request('GET', '/user/profile');
        $this->assertTrue($client->getResponse()->isRedirect('http://localhost/user/login'));

        //Log a test user
        $session = $client->getContainer()->get('session');
        $firewall = 'main';
        $token = new UsernamePasswordToken('testUser', null, $firewall, array('ROLE_USER'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);

        //Trying go to user route being logged
        $crawler = $client->request('GET', '/user/profile');
        $this->assertFalse($client->getResponse()->isRedirect());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("testUser")')->count());
    }

    public function testRegister()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/user/register');

        $buttonCrawlerNode = $crawler->selectButton('_submit');
        $form = $buttonCrawlerNode->form();

        $testForm = array(
            'user[username]'  => 'test',
            'user[firstname]'  => 'test',
            'user[lastname]'  => 'test',
            'user[email]'  => 'test@wineot.fr',
            'user[plain_password][first]'  => 'blabla',
            'user[plain_password][second]' => 'blabla'
        );


//        $client->submit($form, $testForm);
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//
//        $client->submit($form, $testForm);
//        $this->assertGreaterThan(0, $crawler->filter('html:contains("alert alert-danger")')->count());
    }

} 