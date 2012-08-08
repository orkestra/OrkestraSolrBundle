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

use Orkestra\Bundle\SolrBundle\Metadata\ClassMetadata;
use Orkestra\Bundle\SolrBundle\Metadata\PropertyMetadata;

/**
 * Unit tests for ClassMetadata
 *
 * @group orkestra
 */
class ClassMetadataTest extends \PHPUnit_Framework_TestCase
{
    public function testMultipleIdentifiersThrowsException()
    {
        $classMetadata = new ClassMetadata('Orkestra\Bundle\SolrBundle\Tests\Fixture\Person');

        $classMetadata->setIdentifier('id');

        $this->setExpectedException(
            'Orkestra\Bundle\SolrBundle\Exception\MappingException',
            'A mapped class hierarchy may only define a single identifier'
        );

        $classMetadata->setIdentifier('id');
    }
}
