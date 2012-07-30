<?php

namespace Symfony\Bundle\SecurityBundle\Tests\DependencyInjection;

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

        // TODO Test auto mapping
    }

    protected function getContainer($file)
    {
        $container = new ContainerBuilder();
        $extension = new OrkestraSolrExtension();
        $container->registerExtension($extension);
        $this->loadFromFile($container, $file);

        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->setParameter('kernel.bundles', array());
        $container->compile();

        return $container;
    }
}
