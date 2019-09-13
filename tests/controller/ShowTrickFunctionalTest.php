<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ShowTrickFunctionalTest extends WebTestCase
{
    public function testShowTrick()
    {
        $client = static::createClient();

        $client->request('GET', '/snowtrick/melan-yahoo-valaena');

        self::assertSame(200, $client->getResponse()->getStatusCode());
    }
}
