<?php

namespace Orkestra\Bundle\SolrBundle\Tests\Metadata;

use Orkestra\Bundle\SolrBundle\Metadata\ClassMetadata;
use Orkestra\Bundle\SolrBundle\Mapping\Field;

/**
 * Unit tests for ClassMetadata
 *
 * @group orkestra
 */
class ClassMetadataTest extends \PHPUnit_Framework_TestCase
{
    public function testMultipleIdentifierThrowsException()
    {
        $metadata = new ClassMetadata('stdClass');
        $field = new Field(array('name' => 'Test'));

        $this->setExpectedException(
            'Orkestra\Bundle\SolrBundle\Exception\MappingException',
            'A mapped class may only have a single identifier'
        );

        $metadata->setIdentifier($field);
        $metadata->setIdentifier($field);
    }
}
