<?php

/*
 * This file is part of OrkestraSolrBundle
 *
 * Copyright (c) Tyler Sommer <sommertm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Orkestra\Bundle\SolrBundle\Mapping\Persistence;

use Metadata\MetadataFactoryInterface;
use Orkestra\Bundle\SolrBundle\Mapping\Type\TypeFactoryInterface;
use Orkestra\Bundle\SolrBundle\Exception\MappingException;

class PersistenceManager
{
    /**
     * @var \Metadata\MetadataFactoryInterface
     */
    protected $metadataFactory;

    /**
     * @var \Orkestra\Bundle\SolrBundle\Mapping\Type\TypeFactoryInterface
     */
    protected $typeFactory;

    /**
     * Constructor
     *
     * @param \Metadata\MetadataFactoryInterface $metadataFactory
     * @param \Orkestra\Bundle\SolrBundle\Mapping\Type\TypeFactoryInterface $typeFactory
     */
    public function __construct(MetadataFactoryInterface $metadataFactory, TypeFactoryInterface $typeFactory)
    {
        $this->metadataFactory = $metadataFactory;
        $this->typeFactory = $typeFactory;
    }

    /**
     * Gets the value of an object's mapped identifier
     *
     * @param object $object
     *
     * @return \Orkestra\Bundle\SolrBundle\Metadata\PropertyMetadata
     * @throws \Orkestra\Bundle\SolrBundle\Exception\PersistenceException
     */
    public function getIdentifier($object)
    {
        $className = get_class($object);
        $metadata = $this->getMetadata($className);
        if (null === $metadata->identifier) {
            throw MappingException::classHasNoMappedIdentifier($className);
        }

        return $metadata->reflectionIdentifer->getValue($object);
    }

    /**
     * Converts a mapped object to a SolrDocument
     *
     * @param object $object
     *
     * @return \SolrDocument
     */
    public function mapObjectToDocument($object)
    {
        $metadata = $this->getMetadata(get_class($object));
        $document = new \SolrDocument();
        foreach ($metadata->classMetadata as $classMetadata) {
            foreach ($classMetadata->fields as $field) {
                $name = $field['name'];
                $property = $field['property'];
                $document->addField($name, $classMetadata->reflectionFields[$property]->getValue($object));
            }
        }

        return $document;
    }

    /**
     * @param string $className
     *
     * @return \Orkestra\Bundle\SolrBundle\Metadata\ClassHierarchyMetadata
     * @throws \Orkestra\Bundle\SolrBundle\Exception\PersistenceException
     */
    private function getMetadata($className)
    {
        $metadata = $this->metadataFactory->getMetadataForClass($className);

        if (!$metadata) {
            throw MappingException::classIsNotMapped($className);
        }

        return $metadata;
    }
}
