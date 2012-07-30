<?php

namespace Orkestra\Bundle\SolrBundle\Metadata;

use Metadata\ClassMetadata as BaseClassMetadata;
use Orkestra\Bundle\SolrBundle\Mapping\Field;

class ClassMetadata extends BaseClassMetadata
{
    /**
     * @var Orkestra\Bundle\SolrBundle\Mapping\Field
     */
    public $identifier;

    public function setIdentifier(Field $field)
    {
        if (null === $this->identifier) {
            throw new \RuntimeException('A class can have only one identifier');
        }

        $this->identifier = $field;
    }
}
