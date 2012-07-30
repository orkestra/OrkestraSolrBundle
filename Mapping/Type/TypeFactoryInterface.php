<?php

namespace Orkestra\Bundle\SolrBundle\Mapping\Type;

interface TypeFactoryInterface
{
    /**
     * Gets the Type instance associated with the specified name
     *
     * @abstract
     * @param string $typeName
     *
     * @return \Orkestra\Bundle\SolrBundle\Mapping\Type\TypeInterface
     */
    function getType($typeName);
}
