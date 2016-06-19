<?php

namespace Tests\Units\AppBundle\DependencyInjection;

use AppBundle\DependencyInjection\AppExtension;
use AppBundle\Controller\CallbackController;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Tests for AppExtension
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class AppExtensionTest extends \PHPUnit_Framework_TestCase
{
    private $extension;
    private $container;

    protected function setUp()
    {
        $this->extension = new AppExtension();

        $this->container = new ContainerBuilder();
        $this->container->registerExtension($this->extension);

        $this->container->loadFromExtension($this->extension->getAlias());
        $this->container->compile();
    }

    /**
     * @dataProvider getServices
     */
    public function testLoadServices($service, $classname)
    {
        $this->assertTrue($this->container->has($service));

        $this->assertInstanceOf(
            $classname,
            $this->container->get($service)
        );
    }

    public function getServices()
    {
        return [
            ['app.callback_controller', CallbackController::class],
        ];
    }
}