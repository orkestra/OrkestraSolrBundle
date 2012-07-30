<?php

namespace Orkestra\Bundle\SolrBundle;

use Metadata\MetadataFactory;
use Orkestra\Bundle\SolrBundle\Mapping\Persistence\PersistenceManager;

class DocumentManager
{
    /**
     * @var \SolrClient
     */
    protected $solr;

    /**
     * @var \Orkestra\Bundle\SolrBundle\Mapping\Persistence\PersistenceManager
     */
    protected $persistenceManager;

    /**
     * Constructor
     *
     * @param \SolrClient $solr
     * @param \Orkestra\Bundle\SolrBundle\Mapping\Persistence\PersistenceManager $persistenceManager
     */
    public function __construct(\SolrClient $solr, PersistenceManager $persistenceManager)
    {
        $this->solr = $solr;
        $this->persistenceManager = $persistenceManager;
    }

    /**
     * @param object $object
     */
    public function insert($object)
    {
        $document = $this->persistenceManager->mapObjectToDocument($object);

        $this->solr->addDocument($document->getInputDocument());
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
}
