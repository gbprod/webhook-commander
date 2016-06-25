<?php

namespace Tests\Units\AppBundle\Shell;

use AppBundle\Shell\Shell;

/**
 * Tests for shell
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class ShellTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $shell = new Shell();
        $return = $shell->execute('printf "foo"', __DIR__);

        $this->assertEquals('foo', $return);
    }

    public function testExecuteWillExecuteCommandInRightDirectory()
    {
        $shell = new Shell();
        $return = $shell->execute('pwd', __DIR__);

        $this->assertEquals(__DIR__."\n", $return);
    }

    public function testExecuteWillNotChangeCurrendDir()
    {
        $cwd = getcwd();
        $shell = new Shell();
        $return = $shell->execute('printf "foo"', __DIR__);

        $this->assertEquals($cwd, getcwd());
    }
}