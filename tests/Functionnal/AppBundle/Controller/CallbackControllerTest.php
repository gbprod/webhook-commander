<?php

namespace Tests\Functionnal\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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

        $client->request(
            'POST',
            '/webhook/callback',
            [],
            [],
            ['HTTP_X_HUB_SIGNATURE' => 'sha1=f75efc0f29bf50c23f99b30b86f7c78fdaf5f11d'],
            'payload'
        );

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }

    public function testCallbackReturn403()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/webhook/callback',
            [],
            [],
            ['HTTP_X_HUB_SIGNATURE' => 'sha1=fake'],
            'payload'
        );

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }
}