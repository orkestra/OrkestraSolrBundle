<?php

/*
 * This file is part of OrkestraSolrBundle
 *
 * Copyright (c) Tyler Sommer <sommertm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Orkestra\Bundle\SolrBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class YamlOrkestraSolrExtensionTest extends OrkestraSolrExtensionTest
{
    protected function loadFromFile(ContainerBuilder $container, $file)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/Fixtures/yml'));
        $loader->load($file . '.yml');
    }
}
