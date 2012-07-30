<?php

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
fields:
  - { name: id, property: id, identifier: true }
  - { name: name, property: name }
END;

        $locator = $this->getMockForAbstractClass('Symfony\Component\Config\FileLocatorInterface');
        $locator->expects($this->once())
            ->method('locate')
            ->with($this->equalTo('Orkestra.Bundle.SolrBundle.Tests.Metadata.Driver.MockObject.solr.yml'))
            ->will($this->returnValue($config));

        $driver = new YamlDriver($locator);

        $metadata = $driver->loadMetadataForClass(new \ReflectionClass('Orkestra\Bundle\SolrBundle\Tests\Metadata\Driver\MockObject'));

        $this->assertCount(2, $metadata->propertyMetadata);
        $this->assertEquals('id', $metadata->identifier->name);
        $this->assertSame($metadata->identifier, $metadata->propertyMetadata['id']->fields[0]);
        $this->assertNotEmpty($metadata->propertyMetadata['name']);
    }
}
