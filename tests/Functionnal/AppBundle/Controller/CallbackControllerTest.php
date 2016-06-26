<?php

namespace Tests\Functionnal\AppBundle\Controller;

use AppBundle\Shell\Shell;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Functionnal tests for CallbackController
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class CallbackControllerTest extends WebTestCase
{
    private $client;
    private $shell;

    public function setUp()
    {
        $this->client = static::createClient();

        $this->shell = $this->prophesize(Shell::class);
        $this->client->getContainer()->set('app.shell', $this->shell->reveal());
    }
    public function testCallbackReturn204()
    {
        $this->shell
            ->execute('git pull && make deploy', '/var/www/html/miscelaneous')
            ->shouldBeCalled()
        ;

        $this->client->request(
            'POST',
            '/webhook/callback',
            [],
            [],
            ['HTTP_X_HUB_SIGNATURE' => 'sha1=696d01972673c1c21d393ed3ffcc1c425865e159'],
            json_encode([
                'ref' => 'refs/heads/prod',
                'repository' => [
                    'full_name' => 'gbprod/miscelaneous',
                ]
            ])
        );

        $this->assertEquals(204, $this->client->getResponse()->getStatusCode());
    }

    public function testCallbackReturn403()
    {
        $this->client->request(
            'POST',
            '/webhook/callback',
            [],
            [],
            ['HTTP_X_HUB_SIGNATURE' => 'sha1=fake'],
            '{"foo": "bar"}'
        );

        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }
}