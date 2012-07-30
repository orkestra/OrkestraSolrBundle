<?php

namespace Orkestra\Bundle\SolrBundle\Exception;

class MappingException extends \Exception
{
    /**
     * @static
     * @param string $className
     *
     * @return \Orkestra\Bundle\SolrBundle\Exception\PersistenceException
     */
    public static function classIsNotMapped($className)
    {
        return new self(sprintf('Class "%s" is not a mapped Solr document', $className));
    }
}
