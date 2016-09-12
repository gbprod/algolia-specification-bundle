<?php

namespace Tests\GBProd\AlgoliaSpecificationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use GBProd\AlgoliaSpecificationBundle\DependencyInjection\AlgoliaSpecificationExtension;
use GBProd\AlgoliaSpecification\Handler;
use GBProd\AlgoliaSpecification\Registry;

/**
 * Tests for AlgoliaSpecificationExtension
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class AlgoliaSpecificationExtensionTest extends \PHPUnit_Framework_TestCase
{
    private $extension;
    private $container;

    protected function setUp()
    {
        $this->extension = new AlgoliaSpecificationExtension();

        $this->container = new ContainerBuilder();
        $this->container->registerExtension($this->extension);

        $this->container->loadFromExtension($this->extension->getAlias());
        $this->container->compile();
    }

    public function testLoadHasServices()
    {
        $this->assertTrue(
            $this->container->has('gbprod.algolia_specification_registry')
        );

        $this->assertTrue(
            $this->container->has('gbprod.algolia_specification_handler')
        );
    }

    public function testLoadRegistry()
    {
        $registry = $this->container->get('gbprod.algolia_specification_registry');

        $this->assertInstanceOf(Registry::class, $registry);
    }

    public function testLoadHandler()
    {
        $handler = $this->container->get('gbprod.algolia_specification_handler');

        $this->assertInstanceOf(Handler::class, $handler);
    }
}
