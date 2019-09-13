<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddTricksrFunctionalTest extends WebTestCase
{
   
    public function testAddTrick()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/new-trick');
        
        $this->assertTrue($client->getResponse()->isRedirect());
    }
}
