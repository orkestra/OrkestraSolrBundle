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
