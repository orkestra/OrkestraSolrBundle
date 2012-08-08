<?php

/*
 * This file is part of OrkestraSolrBundle
 *
 * Copyright (c) Tyler Sommer <sommertm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Orkestra\Bundle\SolrBundle\Tests\Metadata;

use Orkestra\Bundle\SolrBundle\Metadata\ClassHierarchyMetadata;
use Orkestra\Bundle\SolrBundle\Metadata\ClassMetadata;
use Orkestra\Bundle\SolrBundle\Metadata\PropertyMetadata;

/**
 * Unit tests for ClassHierarchyMetadata
 *
 * @group orkestra
 */
class ClassHierarchyMetadataTest extends \PHPUnit_Framework_TestCase
{
    public function testMultipleIdentifiersThrowsException()
    {
        $classMetadata = new ClassMetadata('Orkestra\Bundle\SolrBundle\Tests\Fixture\Person');
        $classMetadata->setIdentifier('id');

        $classMetadata2 = clone $classMetadata;

        $hierarchyMetadata = new ClassHierarchyMetadata();
        $hierarchyMetadata->addClassMetadata($classMetadata);

        $this->setExpectedException(
            'Orkestra\Bundle\SolrBundle\Exception\MappingException',
            'A mapped class hierarchy may only define a single identifier'
        );

        $hierarchyMetadata->addClassMetadata($classMetadata2);
    }
}
