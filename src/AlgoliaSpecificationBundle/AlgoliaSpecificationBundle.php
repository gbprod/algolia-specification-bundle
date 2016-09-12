<?php

namespace GBProd\AlgoliaSpecificationBundle;

use GBProd\AlgoliaSpecificationBundle\DependencyInjection\Compiler\QueryFactoryPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * AlgoliaSpecificationBundle
 *
 * @author GBProd <contact@gb-prod.fr>
 */
class AlgoliaSpecificationBundle extends Bundle
{
    /**
     * {inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new QueryFactoryPass());
    }
}
