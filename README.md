# Algolia specification bundle

This bundle integrates [algolia-specification](git@github.com:gbprod/algolia-specification.git) with Symfony.

[![Build Status](https://travis-ci.org/gbprod/algolia-specification-bundle.svg?branch=master)](https://travis-ci.org/gbprod/algolia-specification-bundle)
[![codecov](https://codecov.io/gh/gbprod/algolia-specification-bundle/branch/master/graph/badge.svg)](https://codecov.io/gh/gbprod/algolia-specification-bundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gbprod/algolia-specification-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gbprod/algolia-specification-bundle/?branch=master)
[![Dependency Status](https://www.versioneye.com/user/projects/574a9c9ace8d0e004130d337/badge.svg)](https://www.versioneye.com/user/projects/574a9c9ace8d0e004130d337)

[![Latest Stable Version](https://poser.pugx.org/gbprod/algolia-specification-bundle/v/stable)](https://packagist.org/packages/gbprod/algolia-specification-bundle)
[![Total Downloads](https://poser.pugx.org/gbprod/algolia-specification-bundle/downloads)](https://packagist.org/packages/gbprod/algolia-specification-bundle)
[![Latest Unstable Version](https://poser.pugx.org/gbprod/algolia-specification-bundle/v/unstable)](https://packagist.org/packages/gbprod/algolia-specification-bundle)
[![License](https://poser.pugx.org/gbprod/algolia-specification-bundle/license)](https://packagist.org/packages/gbprod/algolia-specification-bundle)

## Installation

Download bundle using [composer](https://getcomposer.org/) :

```bash
composer require gbprod/algolia-specification-bundle
```

Declare in your `app/AppKernel.php` file:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new GBProd\AlgoliaSpecificationBundle\AlgoliaSpecificationBundle(),
        // ...
    );
}
```

## Create your specification and your query factory

Take a look to [Specification](https://github.com/gbprod/specification) and [Algolia Specification](https://github.com/gbprod/specification) libraries for more informations.

### Create a specification

```php
<?php

namespace GBProd\Acme\CoreDomain\Specification\Product;

use GBProd\Specification\Specification;

class IsAvailable implements Specification
{
    public function isSatisfiedBy($candidate)
    {
        return $candidate->isSellable()
            && $candidate->expirationDate() > new \DateTime('now')
        ;
    }
}
```

### Create a query factory

```php
<?php

namespace GBProd\Acme\Infrastructure\Algolia\QueryFactory\Product;

use GBProd\AlgoliaSpecification\QueryFactory\Factory;
use GBProd\Specification\Specification;
use Algolia\QueryBuilder;

class IsAvailableFactory implements Factory
{
    public function create(Specification $spec)
    {
        return 'available=1';
    }
}
```

## Configuration

### Declare your Factory

```yaml
# src/GBProd/Acme/AcmeBundle/Resource/config/service.yml

services:
    acme.algolia.query_factory.is_available:
        class: GBProd\Acme\Infrastructure\Algolia\QueryFactory\Product\IsAvailableFactory
        tags:
            - { name: algolia.query_factory, specification: GBProd\Acme\CoreDomain\Specification\Product\IsAvailable }
```

### Inject handler in your repository class

```yaml
# src/GBProd/Acme/AcmeBundle/Resource/config/service.yml

services:
    acme.product_repository:
        class: GBProd\Acme\Infrastructure\Product\AlgoliaProductRepository
        arguments:
            - "@algolia.client"
            - "@gbprod.algolia_specification_handler"
```

```php
<?php

namespace GBProd\Acme\Infrastructure\Product;

use Algolia\Client;
use GBProd\AlgoliaSpecification\Handler;
use GBProd\Specification\Specification;

class AlgoliaProductRepository implements ProductRepository
{
    private $client;

    private $handler;

    public function __construct(Client $em, Handler $handler)
    {
        $this->client  = $client;
        $this->handler = $handler;
    }

    public function findSatisfying(Specification $specification)
    {
        $index = $this->client->initIndex('products');
        
        $query = $this->handler->handle($specification);
        
        return $type->search(['filters' => $query]);
    }
}
```

### Usage

```php
<?php

$products = $productRepository->findSatisfying(
    new AndX(
        new IsAvailable(),
        new IsLowStock()
    )
);
```
