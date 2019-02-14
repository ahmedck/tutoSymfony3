<?php

namespace Backend\ProductCategoryBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

         $client->request('GET', '/backend/productCategory/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }
}
