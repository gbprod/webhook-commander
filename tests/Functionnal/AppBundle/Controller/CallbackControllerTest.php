<?php

namespace Tests\Functionnal\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Functionnal tests for CallbackController
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class CallbackControllerTest extends WebTestCase
{
    public function testCallbackReturn204()
    {
        $client = static::createClient();

        $client->request('POST', '/webhook/callback');
        
        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }
}