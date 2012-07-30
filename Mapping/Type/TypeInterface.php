<?php

/*
 * This file is part of OrkestraSolrBundle
 *
 * Copyright (c) Tyler Sommer <sommertm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Orkestra\Bundle\SolrBundle\Mapping\Type;

interface TypeInterface
{
    /**
     * Converts a PHP type to a Solr type
     *
     * @abstract
     * @param mixed $value
     *
     * @return mixed
     */
    function convertToSolrValue($value);

    /**
     * Converts a Solr type to a PHP type
     *
     * @abstract
     * @param mixed $value
     *
     * @return mixed
     */
    function convertToPhpValue($value);

    /**
     * Gets the name of the type
     *
     * @abstract
     * @return string
     */
    function getName();
}
