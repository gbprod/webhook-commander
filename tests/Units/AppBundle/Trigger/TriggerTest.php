<?php

namespace Tests\Units\AppBundle\Trigger;

use AppBundle\Trigger\Trigger;

/**
 * Tests for trigger
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class TriggerTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruction()
    {
        $trigger = Trigger::create('repository', 'branch', 'path', 'command');

        $this->assertEquals('repository', $trigger->getRepository());
        $this->assertEquals('branch', $trigger->getBranch());
        $this->assertEquals('path', $trigger->getPath());
        $this->assertEquals('command', $trigger->getCommand());
    }
}