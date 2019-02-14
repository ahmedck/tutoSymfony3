<?php

namespace Backend\DashboardBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/backend/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }
}
