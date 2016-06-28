<?php

namespace Tests\Units\AppBundle\DependencyInjection;

use AppBundle\Controller\CallbackController;
use AppBundle\DependencyInjection\AppExtension;
use AppBundle\EventListener\WebhookValidationListener;
use AppBundle\Shell\Shell;
use AppBundle\Trigger\TriggerRepository;
use AppBundle\Webhook\Handler;
use AppBundle\Webhook\Validator\GithubValidator;
use Psr\Log\LoggerInterface;
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

        $this->container->set('logger', $this->getMock(LoggerInterface::class));
        $this->container->setParameter('kernel.secret', 'my-little-secret');
        $this->container->setParameter('triggers', []);

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
            ['app.webhook_validator', GithubValidator::class],
            ['app.webhook_validation_listener', WebhookValidationListener::class],
            ['app.webhook_handler', Handler::class],
            ['app.trigger_repository', TriggerRepository::class],
            ['app.shell', Shell::class],
        ];
    }
}