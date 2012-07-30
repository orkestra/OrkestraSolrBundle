<?php

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
