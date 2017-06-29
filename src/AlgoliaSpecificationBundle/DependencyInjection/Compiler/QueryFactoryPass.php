<?php

declare(strict_types = 1);

namespace GBProd\AlgoliaSpecificationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Register algolia query factories
 *
 * @author GBProd <contact@gb-prod.fr>
 */
class QueryFactoryPass implements CompilerPassInterface
{
    /**
     * {inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('gbprod.algolia_specification_handler')) {
            throw new \Exception('Missing gbprod.algolia_specification_handler definition');
        }

        $handler = $container->findDefinition('gbprod.algolia_specification_handler');

        $factories = $container->findTaggedServiceIds('algolia.query_factory');

        foreach ($factories as $id => $tags) {
            foreach ($tags as $attributes) {
                if (!isset($attributes['specification'])) {
                    throw new \Exception(
                        'The algolia.query_factory tag must always have a "specification" attribute'
                    );
                }

                $handler->addMethodCall(
                    'registerFactory',
                    [$attributes['specification'], new Reference($id)]
                );
            }
        }
    }
}
