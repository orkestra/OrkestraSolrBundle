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

use Metadata\PropertyMetadata as BasePropertyMetadata;
use Orkestra\Bundle\SolrBundle\Mapping\Field;

class PropertyMetadata extends BasePropertyMetadata
{
    public $fields = array();

    public function addField(Field $field)
    {
        $this->fields[] = $field;
    }
}
