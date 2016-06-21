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
            ['HTTP_X_HUB_SIGNATURE' => 'sha1=0ff9bf78d3a75e3e45302ad860e8408b1129a190'],
            '{"foo": "bar"}'
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
            '{"foo": "bar"}'
        );

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }
}