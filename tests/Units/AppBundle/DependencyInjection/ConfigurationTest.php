<?php

namespace Tests\Units\AppBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use AppBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

/**
 * Tests for Configuration
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    private $configuration;

    public function setUp()
    {
        $this->configuration = new Configuration();
    }

    public function testEmptyConfiguration()
    {
        $processed = $this->process([]);

        $this->assertEquals([], $processed);
    }

    protected function process(array $config)
    {
        $processor = new Processor();

        return $processor->processConfiguration(
            $this->configuration,
            $config
        );
    }
}