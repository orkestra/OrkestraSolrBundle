<?php

/*
 * This file is part of OrkestraSolrBundle
 *
 * Copyright (c) Tyler Sommer <sommertm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Orkestra\Bundle\SolrBundle\Metadata\Driver;

use Metadata\Driver\DriverInterface;
use Orkestra\Bundle\SolrBundle\Exception\MappingException;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\Yaml\Yaml;
use Orkestra\Bundle\SolrBundle\Metadata\ClassMetadata;
use Orkestra\Bundle\SolrBundle\Metadata\PropertyMetadata;
use Orkestra\Bundle\SolrBundle\Mapping\Field;

class YamlDriver implements DriverInterface
{
    /**
     * @var string
     */
    protected $extension = '.solr.yml';

    /**
     * @var \Symfony\Component\Config\FileLocatorInterface
     */
    protected $locator;

    /**
     * @var array
     */
    protected $loadedData = array();

    /**
     * Constructor
     *
     * @param \Symfony\Component\Config\FileLocatorInterface $locator
     */
    public function __construct(FileLocatorInterface $locator)
    {
        $this->locator = $locator;
    }

    /**
     * Attempts to load the metadata for the specified class
     *
     * @param \ReflectionClass $class
     *
     * @return \Orkestra\Bundle\SolrBundle\Metadata\ClassMetadata|null
     */
    public function loadMetadataForClass(\ReflectionClass $class)
    {
        $className = $class->getName();
        $config = $this->getRawMappingData($className);

        if (!$config) {
            return null;
        }

        $classMetadata = new ClassMetadata($className);

        foreach ($config['fields'] as $fieldConfig) {
            if (!isset($classMetadata->propertyMetadata[$fieldConfig['property']])) {
                $classMetadata->addPropertyMetadata(new PropertyMetadata($className, $fieldConfig['property']));
            }

            $metadata = $classMetadata->propertyMetadata[$fieldConfig['property']];

            $field = new Field($fieldConfig);
            $metadata->addField($field);
            if ($field->identifier) {
                $classMetadata->setIdentifier($metadata);
            }
        }

        return $classMetadata;
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
                $data = Yaml::parse($fullPath);
                if (!isset($data[$className])) {
                    throw MappingException::invalidMapping($fullPath);
                }

                $this->loadedData[$className] = $data[$className];
            }
        }

        return isset($this->loadedData[$className]) ? $this->loadedData[$className] : null;
    }
}
