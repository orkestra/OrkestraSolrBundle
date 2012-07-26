<?php

namespace Orkestra\Bundle\SolrBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Definition;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class OrkestraSolrExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $solrDefinition = $container->getDefinition('orkestra.solr');
        $solrDefinition->addArgument($config['solr']);

        foreach ($config['mapping']['files'] as $file) {
            if (!file_exists($file)) {
                throw new \RuntimeException(sprintf('Solr mapping file %s does not exist', $file));
            }

            $container->addResource(new FileResource($file));
        }

        $container->setParameter('orkestra.solr.mapping.files', $config['mapping']['files']);
    }
}
