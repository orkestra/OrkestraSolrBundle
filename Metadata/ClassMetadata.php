<?php

namespace Orkestra\Bundle\SolrBundle\Metadata;

use Metadata\ClassMetadata as BaseClassMetadata;
use Orkestra\Bundle\SolrBundle\Mapping\Field;

class ClassMetadata extends BaseClassMetadata
{
    public $fields = array();

    public function addField(Field $field)
    {
        $this->fields[] = $field;
    }
}
