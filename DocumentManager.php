<?php

namespace Orkestra\Bundle\SolrBundle;

use Metadata\MetadataFactory;

class DocumentManager
{
    protected $solr;

    protected $metadataFactory;

    public function __construct(\SolrClient $solr, MetadataFactory $metadataFactory)
    {
        $this->solr = $solr;
        $this->metadataFactory = $metadataFactory;
    }

    public function insert($document)
    {
        $className = get_class($document);

        /** @var \Metadata\ClassHierarchyMetadata $metadata */
        $metadata = $this->metadataFactory->getMetadataForClass($className);

        if (!$metadata) {
            throw new \RuntimeException('No metadata information for ' . $className);
        }

        $inputDocument = new \SolrInputDocument();

        foreach ($metadata->classMetadata as $classMetdata) {
            foreach ($classMetdata->propertyMetadata as $propertyMetadata) {
                foreach ($propertyMetadata->fields as $field) {
                    /** @var \Orkestra\Bundle\SolrBundle\Mapping\Field $field */
                    $inputDocument->addField($field->name, $propertyMetadata->getValue($document));
                }
            }
        }

        try {
            return $this->solr->addDocument($inputDocument);
        } catch (\SolrClientException $e) {
            $msg = strip_tags($e->getMessage());

            throw $e;
        }
    }

    public function commit()
    {
        return $this->solr->commit();
    }

    public function rollback()
    {
        return $this->solr->rollback();
    }

    public function delete($document)
    {

    }

    public function find(\SolrQuery $query)
    {
        return $this->solr->query($query);
    }

    public function createQuery($query = '')
    {
        return new \SolrQuery($query);
    }

    private function getIdentifier($document)
    {

    }
}
