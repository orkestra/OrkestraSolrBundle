<?php

namespace Orkestra\Bundle\SolrBundle\Mapping\Persistence;

use Metadata\MetadataFactoryInterface;
use Orkestra\Bundle\SolrBundle\Mapping\Type\TypeFactoryInterface;
use Orkestra\Bundle\SolrBundle\Exception\MappingException;

class PersistenceManager
{
    protected $metadataFactory;

    protected $typeFactory;

    public function __construct(MetadataFactoryInterface $metadataFactory, TypeFactoryInterface $typeFactory)
    {
        $this->metadataFactory = $metadataFactory;
        $this->typeFactory = $typeFactory;
    }

    public function getIdentifier($object)
    {

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
            foreach ($classMetadata->propertyMetadata as $propertyMetadata) {
                foreach ($propertyMetadata->fields as $field) {
                    /** @var \Orkestra\Bundle\SolrBundle\Mapping\Field $field */
                    $document->addField($field->name, $propertyMetadata->getValue($object));
                }
            }
        }

        return $document;
    }

    /**
     * @param string $className
     *
     * @return \Metadata\ClassHierarchyMetadata
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
