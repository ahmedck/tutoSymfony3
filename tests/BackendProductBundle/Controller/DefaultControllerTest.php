<?php

namespace Backend\ProductBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/backend/product/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}