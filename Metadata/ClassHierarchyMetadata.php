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

use Metadata\ClassHierarchyMetadata as BaseClassHierarchyMetadata;
use Metadata\ClassMetadata as BaseClassMetadata;
use Orkestra\Bundle\SolrBundle\Exception\MappingException;

class ClassHierarchyMetadata extends BaseClassHierarchyMetadata
{
    /**
     * @var string
     */
    public $identifier;

    /**
     * @var \ReflectionProperty
     */
    public $reflectionIdentifer;

    /**
     * @param \Orkestra\Bundle\SolrBundle\Metadata\ClassMetadata $metadata
     *
     * @throws \Orkestra\Bundle\SolrBundle\Exception\PersistenceException
     */
    public function addClassMetadata(BaseClassMetadata $metadata)
    {
        if ($metadata->identifier) {
            if (null !== $this->identifier) {
                throw MappingException::classMayNotHaveMultipleIdentifiers();
            }

            $this->identifier = $metadata->identifier;

            // TODO: This is not the most elegant way to handle this
            $this->reflectionIdentifer = $metadata->reflectionFields[$metadata->identifier];
        }

        $this->classMetadata[$metadata->name] = $metadata;
    }
}
