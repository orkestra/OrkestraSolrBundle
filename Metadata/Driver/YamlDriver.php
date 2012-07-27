<?php

namespace Orkestra\Bundle\SolrBundle\Mapping\Driver;

use Metadata\Driver\DriverInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Yaml\Yaml;
use Orkestra\Bundle\SolrBundle\Metadata\ClassMetadata;
use Orkestra\Bundle\SolrBundle\Mapping\Field;

class YamlDriver implements DriverInterface
{
    protected $extension = '.solr.yml';

    protected $locator;

    protected $loadedData = null;

    public function __construct(FileLocatorInterface $locator)
    {
        $this->locator = $locator;
    }

    public function loadMetadataForClass(\ReflectionClass $class)
    {
        $className = $class->getName();
        $metadata = new ClassMetadata($className);
        $config = $this->getRawMappingData($className);

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
    protected function getRawMappingData($className)
    {
        if (!isset($this->loadedData[$className])) {
            $baseFilename = str_replace('\\', '.', $className) . $this->extension;
            $fullPath = null;

            try {
                $fullPath = $this->locator->locate($baseFilename);
            } catch (\InvalidArgumentException $e) { }

            if ($fullPath) {
                $this->loadedData[$className] = Yaml::parse($fullPath);
            }
        }

        return isset($this->loadedData[$className]) ? $this->loadedData[$className] : null;
    }
}
