<?php

/*
 * This file is part of OrkestraSolrBundle
 *
 * Copyright (c) Tyler Sommer <sommertm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Orkestra\Bundle\SolrBundle\Metadata;

use Metadata\ClassMetadata as BaseClassMetadata;
use Orkestra\Bundle\SolrBundle\Exception\MappingException;

class ClassMetadata extends BaseClassMetadata
{
    /**
     * @var \Orkestra\Bundle\SolrBundle\Metadata\PropertyMetadata
     */
    public $identifier;

    public function setIdentifier(PropertyMetadata $metadata)
    {
        if (null !== $this->identifier) {
            throw new MappingException('A mapped class may only have a single identifier');
        }

        $this->identifier = $metadata;
    }
}
