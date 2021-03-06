<?php

/*
 * This file is part of OrkestraSolrBundle
 *
 * Copyright (c) Tyler Sommer <sommertm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Orkestra\Bundle\SolrBundle\Mapping;

/**
 * Maps a property to a field defined in a Solr schema
 *
 * @Annotation
 * @Target("PROPERTY")
 */
final class Field
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $type = 'string';

    /**
     * @var bool
     */
    public $identifier = false;

    public function __construct(array $values)
    {
        if (!isset($values['name'])) {
            throw new \InvalidArgumentException('You must define a "name" attribute for each Field annotation');
        }

        $this->name = $values['name'];

        if (isset($values['type'])) {
            $this->type = $values['type'];
        }

        if (isset($values['identifier'])) {
            $this->identifier = $values['identifier'] ? true : false;
        }
    }
}
