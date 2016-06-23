<?php

namespace Tests\Units\AppBundle\Trigger;

use AppBundle\Trigger\InMemoryTriggerRepository;
use AppBundle\Trigger\Trigger;

/**
 * Tests for InMemoryTriggerRepository
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class InMemoryTriggerRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFindMatching()
    {
        $repository = new InMemoryTriggerRepository([
            'app1' => [
                'path' => 'my/path/',
                'command' => 'make deploy',
                'repository' => 'foo/bar',
                'branch' => 'master',
            ],
            'app2' => [
                'path' => 'my/second/path/',
                'command' => 'deploy.sh',
                'repository' => 'gbprod/miscelaneous',
                'branch' => 'prod',
            ],
            'app3' => [
                'path' => 'my/third/path/',
                'command' => 'mep.sh',
                'repository' => 'gbprod/miscelaneous',
                'branch' => 'prod',
            ],
        ]);

        $matching = $repository->findMatching('gbprod/miscelaneous', 'prod');

        $this->assertCount(2, $matching);
        $this->assertEquals(
            Trigger::create('gbprod/miscelaneous', 'prod', 'my/second/path/', 'deploy.sh'),
            $matching[0]
        );
        $this->assertEquals(
            Trigger::create('gbprod/miscelaneous', 'prod', 'my/third/path/', 'mep.sh'),
            $matching[1]
        );
    }
}