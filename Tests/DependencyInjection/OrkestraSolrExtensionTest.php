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
use Orkestra\Bundle\SolrBundle\DependencyInjection\OrkestraSolrExtension;

abstract class OrkestraSolrExtensionTest extends \PHPUnit_Framework_TestCase
{
    abstract protected function loadFromFile(ContainerBuilder $container, $file);

    public function testBasicConfiguration()
    {
        $container = $this->getContainer('basic');

        $this->assertEquals(array(
            'hostname' => 'localhost',
            'port' => '8443',
            'username' => 'user',
            'password' => 'pass'
        ), $container->getParameter('orkestra.solr.connection'));

        $definition = $container->getDefinition('orkestra.solr.metadata.driver.file_locator');
        $this->assertEquals(array(
            __DIR__ . '/Resources/config/solr'
        ), $definition->getArgument(0));
    }

    protected function getContainer($file)
    {
        $container = new ContainerBuilder();
        $extension = new OrkestraSolrExtension();
        $container->registerExtension($extension);
        $this->loadFromFile($container, $file);

        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->setParameter('kernel.bundles', array('Orkestra\Bundle\SolrBundle\Tests\DependencyInjection\FakeBundle'));
        $container->compile();

        return $container;
    }
}

class FakeBundle
{

}
