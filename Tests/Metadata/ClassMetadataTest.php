<?php

namespace Orkestra\Bundle\SolrBundle\Tests\Metadata;

use Orkestra\Bundle\SolrBundle\Metadata\ClassMetadata;
use Orkestra\Bundle\SolrBundle\Metadata\PropertyMetadata;

/**
 * Unit tests for ClassMetadata
 *
 * @group orkestra
 */
class ClassMetadataTest extends \PHPUnit_Framework_TestCase
{
    public function testMultipleIdentifierThrowsException()
    {
        $classMetadata = new ClassMetadata('Orkestra\Bundle\SolrBundle\Tests\Metadata\Driver\MockObject');
        $propertyMetadata = new PropertyMetadata('Orkestra\Bundle\SolrBundle\Tests\Metadata\Driver\MockObject', 'id');

        $classMetadata->setIdentifier($propertyMetadata);

        $this->setExpectedException(
            'Orkestra\Bundle\SolrBundle\Exception\MappingException',
            'A mapped class may only have a single identifier'
        );

        $classMetadata->setIdentifier($propertyMetadata);
    }
}
