<?php

namespace Tests\Units\AppBundle;

use AppBundle\AppBundle;

class AppBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruction()
    {
        $this->assertInstanceOf(
            AppBundle::class,
            new AppBundle()
        );
    }
}