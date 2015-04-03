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

class SecurityControllerTest extends WebTestCase
{
    public function testUserPageDown()
    {
        $client = static::createClient();

        $client->request('GET', '/user/login');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET', '/user/register');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testUserFirewall()
    {
        $client = static::createClient();

        //Trying go to user route without being logged
        $client->request('GET', '/user/profile');
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
        $client->request('GET', '/user/profile');
        $this->assertFalse($client->getResponse()->isRedirect());
    }

    public function testUserFormRegister()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/user/register');

        $buttonCrawlerNode = $crawler->selectButton('submit_user_register');
        $form = $buttonCrawlerNode->form();

        $testForm = array(
            'wineot_databundle_user[username]'  => 'test',
            'wineot_databundle_user[firstname]'  => 'test',
            'wineot_databundle_user[lastname]'  => 'test',
            'wineot_databundle_user[mail]'  => 'test@wineot.fr',
            'wineot_databundle_user[plain_password][first]'  => 'blabla',
            'wineot_databundle_user[plain_password][second]' => 'blabla'
        );

        $response = $client->getResponse();

        $client->submit($form, $testForm);
        $this->assertTrue($response->isSuccessful());

//        $client->submit($form, $testForm);
//        $this->assertGreaterThan(0, $crawler->filter('html:contains("alert alert-danger")')->count());
    }

} 