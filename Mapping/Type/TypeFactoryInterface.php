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
