<?php

namespace Tests\GBProd\AlgoliaSpecificationBundle\DependencyInjection;

use GBProd\AlgoliaSpecificationBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Tests for Configuration
 *
 * @author gbprod <contact@gb-prod.fr>
 */
class ConfigurationTest extends TestCase
{
    public function testGetConfigTreeBuilder()
    {
        $configuration = new Configuration();

        $tree = $configuration->getConfigTreeBuilder();

        $this->assertInstanceOf(TreeBuilder::class, $tree);

        $this->assertEquals(
            'algolia_specification_bundle',
            $tree->buildTree()->getName()
        );
    }
}
