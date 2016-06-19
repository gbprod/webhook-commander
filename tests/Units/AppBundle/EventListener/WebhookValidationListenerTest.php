<?php

namespace Tests\Units\AppBundle\EventListener;

use AppBundle\EventListener\WebhookValidationListener;
use AppBundle\Webhook\Validator\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Tests for WebhookValidationListener
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class WebhookValidationListenerTest extends \PHPUnit_Framework_TestCase
{
    private $listener;

    private $validator;

    public function setUp()
    {
        $this->validator = $this->prophesize(Validator::class);
        $this->listener = new WebhookValidationListener($this->validator->reveal());
    }

    public function testNotValidateRequest()
    {
        $request = new Request();
        $event = $this->newEvent($request);

        $this
            ->validator
            ->validate($request)
            ->willReturn(false)
        ;

        $this->setExpectedException(AccessDeniedHttpException::class);
        $this->listener->onKernelController($event);
    }

    private function newEvent($request)
    {
        $event = $this->prophesize(FilterControllerEvent::class);
        $controller = $this->prophesize(Controller::class);

        $event
            ->getController()
            ->willReturn([$controller])
        ;

        $event
            ->getRequest()
            ->willReturn($request)
        ;

        return $event->reveal();
    }

    public function testValidateRequest()
    {
        $request = new Request();
        $event = $this->newEvent($request);

        $this
            ->validator
            ->validate($request)
            ->willReturn(true)
        ;

        $this->assertNull(
            $this->listener->onKernelController($event)
        );
    }

    public function testSkipIfControllerIsAClosure()
    {
        $request = new Request();
        $event = $this->newEventWithControllerAsClosure($request);

        $this
            ->validator
            ->validate($request)
            ->shouldNotBeCalled()
        ;

        $this->assertNull(
            $this->listener->onKernelController($event)
        );
    }

    private function newEventWithControllerAsClosure($request)
    {
        $event = $this->prophesize(FilterControllerEvent::class);
        $controller = function() {};

        $event
            ->getController()
            ->willReturn($controller)
        ;

        $event
            ->getRequest()
            ->willReturn($request)
        ;

        return $event->reveal();
    }
}