<?php

/*
 * This file is part of OrkestraSolrBundle
 *
 * Copyright (c) Tyler Sommer <sommertm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Orkestra\Bundle\SolrBundle\Exception;

/**
 * A mapping related exception
 */
class MappingException extends \Exception
{
    /**
     * Thrown when metadata for a class with no mapped metadata is requested
     *
     * @static
     * @param string $className
     *
     * @return \Orkestra\Bundle\SolrBundle\Exception\PersistenceException
     */
    public static function classIsNotMapped($className)
    {
        return new self(sprintf('Class "%s" is not a mapped Solr document', $className));
    }

    /**
     * Thrown when multiple identifiers are mapped to a class hierarchy
     *
     * @static
     *
     * @return \Orkestra\Bundle\SolrBundle\Exception\PersistenceException
     */
    public static function classMayNotHaveMultipleIdentifiers()
    {
        return new self('A mapped class hierarchy may only define a single identifier');
    }

    /**
     * Thrown when the identifier for a class without one is requested
     *
     * @static
     * @param string $className
     *
     * @return \Orkestra\Bundle\SolrBundle\Exception\PersistenceException
     */
    public static function classHasNoMappedIdentifier($className)
    {
        return new self(sprintf('The class "%s" has no mapped identifier', $className));
    }
}
