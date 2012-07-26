<?php

namespace Orkestra\Bundle\SolrBundle\Mapping\Driver;

use Metadata\Driver\DriverInterface;
use Symfony\Component\Yaml\Yaml;
use Orkestra\Bundle\SolrBundle\Metadata\ClassMetadata;
use Orkestra\Bundle\SolrBundle\Mapping\Field;

class YamlDriver implements DriverInterface
{
    protected $loaded = false;

    protected $config = array();

    protected $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function loadMetadataForClass(\ReflectionClass $class)
    {
        $className = $class->getName();
        $metadata = new ClassMetadata($className);
        $config = $this->getConfigurationForClass($className);

        if (!$config) {
            return null;
        }

        foreach ($config['fields'] as $fieldConfig) {
            $metadata->addField(new Field($fieldConfig));
        }

        return $metadata;
    }

    /**
     * @param string $className
     *
     * @return array
     */
    protected function getConfigurationForClass($className)
    {
        if (!$this->loaded) {
            $this->loadMappingFile();
        }

        return isset($this->config[$className]) ? $this->config[$className] : null;
    }

    protected function loadMappingFile()
    {
        $this->config = Yaml::parse($this->filename);
        $this->loaded = true;
    }
}
