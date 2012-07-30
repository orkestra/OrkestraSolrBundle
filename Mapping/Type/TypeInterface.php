<?php

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
