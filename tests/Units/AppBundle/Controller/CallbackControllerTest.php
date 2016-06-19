<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Controller\CallbackController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tests for CallbackController
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class CallbackControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testCallbackReturn204()
    {
        $controller = new CallbackController();
        
        $response = $controller->callback();
        
        $this->assertInstanceOf(Response::class, $response);
    }
}
