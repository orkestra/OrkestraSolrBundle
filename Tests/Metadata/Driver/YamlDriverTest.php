<?php

/*
 * This file is part of OrkestraSolrBundle
 *
 * Copyright (c) Tyler Sommer <sommertm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Orkestra\Bundle\SolrBundle\Tests\Metadata\Driver;

use Orkestra\Bundle\SolrBundle\Metadata\Driver\YamlDriver;

/**
 * Unit tests for YamlDriver
 *
 * @group orkestra
 */
class YamlDriverTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadMetadataForClass()
    {
        $config = <<<END
Orkestra\Bundle\SolrBundle\Tests\Fixture\Person:
  id:            id
  fields:
    person_id:   { property: id }
    person_name: { property: name }
END;

        $locator = $this->getMockForAbstractClass('Symfony\Component\Config\FileLocatorInterface');
        $locator->expects($this->once())
            ->method('locate')
            ->with($this->equalTo('Orkestra.Bundle.SolrBundle.Tests.Fixture.Person.solr.yml'))
            ->will($this->returnValue($config));

        $driver = new YamlDriver($locator);

        $metadata = $driver->loadMetadataForClass(new \ReflectionClass('Orkestra\Bundle\SolrBundle\Tests\Fixture\Person'));

        $this->assertCount(2, $metadata->fields);
        $this->assertEquals('id', $metadata->identifier);
        $this->assertEquals('id', $metadata->fields['person_id']['property']);
        $this->assertEquals('name', $metadata->fields['person_name']['property']);
    }
}
