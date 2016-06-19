<?php

namespace Tests\Units\AppBundle\Webhook\Validator;

use AppBundle\Webhook\Validator\GithubValidator;
use Symfony\Component\HttpFoundation\Request;


/**
 * Tests for GithubValidator
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class GithubValidatorTest extends \PHPUnit_Framework_TestCase
{
    private $validator;
    private $request;

    public function setUp()
    {
        $this->validator = new GithubValidator('secret');
        $this->request = new Request([], [], [], [], [], [], 'payload');
    }

    public function testValidRequest()
    {
        $this->request->headers->set(
            'X-Hub-Signature',
            'sha1=f75efc0f29bf50c23f99b30b86f7c78fdaf5f11d'
        );

        $this->assertTrue(
            $this->validator->validate($this->request)
        );
    }

    public function testInvalidAlgo()
    {
        $this->request->headers->set(
            'X-Hub-Signature',
            'md5=f75efc0f29bf50c23f99b30b86f7c78fdaf5f11d'
        );

        $this->assertFalse(
            $this->validator->validate($this->request)
        );
    }

    public function testInvalidIfNoSignature()
    {
        $this->assertFalse(
            $this->validator->validate($this->request)
        );
    }
}
