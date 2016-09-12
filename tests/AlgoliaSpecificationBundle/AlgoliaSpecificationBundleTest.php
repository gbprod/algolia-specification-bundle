<?php

namespace Tests\GBProd\AlgoliaSpecificationBundle;

use GBProd\AlgoliaSpecificationBundle\DependencyInjection\Compiler\QueryFactoryPass;
use GBProd\AlgoliaSpecificationBundle\AlgoliaSpecificationBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Tests for AlgoliaSpecificationBundle
 *
 * @author GBProd <contact@gb-prod.fr>
 */
class AlgoliaSpecificationBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruction()
    {
        $bundle = new AlgoliaSpecificationBundle();

        $this->assertInstanceOf(AlgoliaSpecificationBundle::class, $bundle);
        $this->assertInstanceOf(Bundle::class, $bundle);
    }

    public function testBuildAddCompilerPass()
    {
        $container = $this->prophesize(ContainerBuilder::class);
        $container
            ->addCompilerPass(new QueryFactoryPass())
            ->shouldBeCalled()
        ;

        $bundle = new AlgoliaSpecificationBundle();
        $bundle->build($container->reveal());
    }
}
