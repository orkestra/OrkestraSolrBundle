<?php

/*
 * This file is part of OrkestraSolrBundle
 *
 * Copyright (c) Tyler Sommer <sommertm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Orkestra\Bundle\SolrBundle\Tests\Persistence;

use Orkestra\Bundle\SolrBundle\Mapping\Persistence\PersistenceManager;
use Orkestra\Bundle\SolrBundle\Mapping\Field;
use Orkestra\Bundle\SolrBundle\Metadata\PropertyMetadata;
use Orkestra\Bundle\SolrBundle\Metadata\ClassMetadata;
use Orkestra\Bundle\SolrBundle\Metadata\ClassHierarchyMetadata;
use Orkestra\Bundle\SolrBundle\Tests\Fixture\Person;

/**
 * Unit tests for PersistenceManager
 *
 * @group orkestra
 */
class PersistenceManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testMapObjectToDocument()
    {
        $mockTypeFactory = $this->getMockForAbstractClass('Orkestra\Bundle\SolrBundle\Mapping\Type\TypeFactoryInterface');
        $mockMetadataFactory = $this->getMockForAbstractClass('Metadata\MetadataFactoryInterface');
        $mockMetadataFactory->expects($this->once())
            ->method('getMetadataForClass')
            ->will($this->returnValue($this->getMetadata()));

        $manager = new PersistenceManager($mockMetadataFactory, $mockTypeFactory);

        $person = new Person();
        $person->id = 5;
        $person->name = 'Tyler';
        $person->dateModified = '2011-01-01';

        $document = $manager->mapObjectToDocument($person);

        $this->assertEquals(3, $document->getFieldCount());
        $this->assertCount(1, $document->getField('id')->values);
        $this->assertCount(1, $document->getField('name')->values);
        $this->assertCount(1, $document->getField('dateModified')->values);
        $this->assertEquals(5, $document->getField('id')->values[0]);
        $this->assertEquals('Tyler', $document->getField('name')->values[0]);
        $this->assertEquals('2011-01-01', $document->getField('dateModified')->values[0]);
    }

    private function getMetadata()
    {
        $propertyMetadata = new PropertyMetadata('Orkestra\Bundle\SolrBundle\Tests\Fixture\Person', 'id');
        $propertyMetadata->addField(new Field(array('name' => 'id', 'identifier' => true)));
        $classMetadata = new ClassMetadata('Orkestra\Bundle\SolrBundle\Tests\Fixture\Person');
        $classMetadata->addPropertyMetadata($propertyMetadata);
        $classMetadata->setIdentifier($propertyMetadata);
        $propertyMetadata = new PropertyMetadata('Orkestra\Bundle\SolrBundle\Tests\Fixture\Person', 'name');
        $propertyMetadata->addField(new Field(array('name' => 'name')));
        $classMetadata->addPropertyMetadata($propertyMetadata);
        $propertyMetadata = new PropertyMetadata('Orkestra\Bundle\SolrBundle\Tests\Fixture\Person', 'dateModified');
        $propertyMetadata->addField(new Field(array('name' => 'dateModified', 'type' => 'date')));
        $classMetadata->addPropertyMetadata($propertyMetadata);
        $metadata = new ClassHierarchyMetadata();
        $metadata->addClassMetadata($classMetadata);

        return $metadata;
    }

    public function testGetIdentifier()
    {
        $propertyMetadata = new PropertyMetadata('Orkestra\Bundle\SolrBundle\Tests\Fixture\Person', 'id');
        $propertyMetadata->addField(new Field(array('name' => 'id', 'identifier' => true)));
        $classMetadata = new ClassMetadata('Orkestra\Bundle\SolrBundle\Tests\Fixture\Person');
        $classMetadata->setIdentifier($propertyMetadata);
        $metadata = new ClassHierarchyMetadata();
        $metadata->addClassMetadata($classMetadata);

        $mockTypeFactory = $this->getMockForAbstractClass('Orkestra\Bundle\SolrBundle\Mapping\Type\TypeFactoryInterface');
        $mockMetadataFactory = $this->getMockForAbstractClass('Metadata\MetadataFactoryInterface');
        $mockMetadataFactory->expects($this->once())
            ->method('getMetadataForClass')
            ->will($this->returnValue($metadata));

        $manager = new PersistenceManager($mockMetadataFactory, $mockTypeFactory);

        $person = new Person();
        $person->id = 5;

        $id = $manager->getIdentifier($person);

        $this->assertEquals(5, $id);
    }

    public function testGetIdentifierThrowsExceptionIfNoMappedIdentifier()
    {
        $metadata = new ClassHierarchyMetadata();

        $mockTypeFactory = $this->getMockForAbstractClass('Orkestra\Bundle\SolrBundle\Mapping\Type\TypeFactoryInterface');
        $mockMetadataFactory = $this->getMockForAbstractClass('Metadata\MetadataFactoryInterface');
        $mockMetadataFactory->expects($this->once())
            ->method('getMetadataForClass')
            ->will($this->returnValue($metadata));

        $manager = new PersistenceManager($mockMetadataFactory, $mockTypeFactory);

        $person = new Person();
        $person->id = 5;

        $this->setExpectedException(
            'Orkestra\Bundle\SolrBundle\Exception\MappingException',
            'The class "Orkestra\Bundle\SolrBundle\Tests\Fixture\Person" has no mapped identifier'
        );

        $manager->getIdentifier($person);
    }
}
