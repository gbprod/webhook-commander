<?php

namespace Tests\Units\AppBundle\Webhook;

use AppBundle\Shell\Shell;
use AppBundle\Trigger\Trigger;
use AppBundle\Trigger\TriggerRepository;
use AppBundle\Webhook\Handler;

/**
 * Tests for Webhook handler
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class HandlerTest extends \PHPUnit_Framework_TestCase
{
    private $repository;
    private $shell;
    private $testedInstance;

    public function setUp()
    {
        $this->repository = $this->prophesize(TriggerRepository::class);
        $this->shell = $this->prophesize(Shell::class);

        $this->testedInstance = new Handler(
            $this->repository->reveal(),
            $this->shell->reveal()
        );
    }

    public function testWillExecuteCommandOfFoundTrigger()
    {
        $this->repository
            ->findMatching('gbprod/miscelaneous', 'prod')
            ->willReturn([
                Trigger::create('gbprod/miscelaneous', 'prod', 'my/first/path/', 'deploy.sh'),
                Trigger::create('gbprod/miscelaneous', 'prod', 'my/second/path/', 'make install'),
            ])
        ;

        $this->shell
            ->execute('deploy.sh', 'my/first/path/')
            ->shouldBeCalled()
        ;

        $this->shell
            ->execute('make install', 'my/second/path/')
            ->shouldBeCalled()
        ;

        $this->testedInstance
            ->handle(
                [
                    'ref' => 'refs/heads/prod',
                    'repository' => [
                        'full_name' => 'gbprod/miscelaneous',
                    ]
                ]
            )
        ;
    }
}