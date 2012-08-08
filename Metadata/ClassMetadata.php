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
     * @var string
     */
    public $identifier;

    /**
     * @var array
     */
    public $fields = array();

    /**
     * @var array
     */
    public $reflectionFields = array();

    /**
     * Constructor
     *
     * @param string $name The fully qualified class name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        // TODO: Investigate lazy loading
        foreach ($this->reflection->getProperties() as $reflectionField) {
            $reflectionField->setAccessible(true);
            $this->reflectionFields[$reflectionField->getName()] = $reflectionField;
        }
    }

    /**
     * Sets the mapped identifier
     *
     * @param string $field
     *
     * @throws \Orkestra\Bundle\SolrBundle\Exception\MappingException
     */
    public function setIdentifier($field)
    {
        if (null !== $this->identifier) {
            throw MappingException::classMayNotHaveMultipleIdentifiers();
        }

        $this->identifier = $field;
    }

    /**
     * Adds a field mapping
     *
     * @param array $field
     */
    public function addField($field)
    {
        $this->fields[$field['name']] = $field;
    }
}
