<?php

namespace Orkestra\Bundle\SolrBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class OrkestraSolrExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('orkestra.solr.connection', $config['connection']);

        $this->configureMetadataDriver($container, $config);
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @param array $config
     */
    private function configureMetadataDriver(ContainerBuilder $container, $config)
    {
        if ($config['auto_mapping']) {
            $locatorDefinition = $container->register('orkestra.solr.metadata.driver.file_locator', 'Symfony\Component\Config\FileLocator');
            $locatorDefinition->setArguments(array($this->getMappingPaths($container)));

            $driverDefinition = $container->getDefinition('orkestra.solr.metadata.driver');
            $driverDefinition->setClass('Orkestra\Bundle\SolrBundle\Metadata\Driver\YamlDriver');
            $driverDefinition->setArguments(array(new Reference('orkestra.solr.metadata.driver.file_locator')));

            // TODO Use DriverChain to allow yml and xml configurations
            // TODO How to support annotations with auto mapping
        } else {
            // TODO Implement explicit driver configuration
        }
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return array
     */
    private function getMappingPaths(ContainerBuilder $container)
    {
        $paths = array();

        foreach ($container->getParameter('kernel.bundles') as $bundle) {
            $reflected = new \ReflectionClass($bundle);
            $paths[] = dirname($reflected->getFilename()) . '/Resources/config/solr';
        }

        return $paths;
    }
}
