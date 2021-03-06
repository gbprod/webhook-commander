<?php

namespace Tests\Units\AppBundle\Controller;

use AppBundle\Controller\CallbackController;
use AppBundle\Webhook\Handler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tests for CallbackController
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class CallbackControllerTest extends \PHPUnit_Framework_TestCase
{
    private $handler;

    private $controller;

    public function setUp()
    {
        $this->handler = $this->prophesize(Handler::class);
        $this->controller = new CallbackController(
            $this->handler->reveal()
        );
    }

    public function testCallbackReturn204()
    {
        $request = $this->newRequest('{}');

        $response = $this->controller->callback($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }

    /**
     * @param string $content
     */
    private function newRequest($content)
    {
        return new Request([], [], [], [], [], [], $content);
    }

    public function testCallbackWillCallHandlerWithUnserializedPayload()
    {
        $request = $this->newRequest('{"foo": "bar"}');

        $this
            ->handler
            ->handle(['foo' => 'bar'])
            ->shouldBeCalled()
        ;

        $this->controller->callback($request);
    }

}
