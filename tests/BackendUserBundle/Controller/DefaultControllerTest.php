<?php

namespace Backend\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/backend/user/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
