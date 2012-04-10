<?php

/*
 * This file is a part of dflydev/dot-access-configuration.
 * 
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Tests\DotAccessConfiguration;

use Dflydev\DotAccessConfiguration\Configuration;
use Dflydev\DotAccessConfiguration\ConfigurationInterface;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    protected function getSampleData()
    {
        return array(
            'a' => 'A',
            'b' => array(
                'b' => 'B',
                'c' => array('C1', 'C2', 'C3'),
                'd' => array(
                    'd1' => 'D1',
                    'd2' => 'D2',
                    'd3' => 'D3',
                ),
            ),
            'c' => array('c1', 'c2', 'c3'),
        );
    }

    protected function runSampleDataTests(ConfigurationInterface $configuration)
    {
        $this->assertEquals('A', $configuration->get('a'));
        $this->assertEquals('B', $configuration->get('b.b'));
        $this->assertEquals(array('C1', 'C2', 'C3'), $configuration->get('b.c'));
        $this->assertEquals('D3', $configuration->get('b.d.d3'));
        $this->assertEquals(array('c1', 'c2', 'c3'), $configuration->get('c'));
        $this->assertEquals(null, $configuration->get('foo'), 'Foo should not exist');
    }

    public function testAppend()
    {
        $this->markTestSkipped();
    }

    public function testSet()
    {
        $this->markTestSkipped();
    }

    public function testRemote()
    {
        $this->markTestSkipped();
    }

    public function testGet()
    {
        $configuration = new Configuration($this->getSampleData());

        $this->runSampleDataTests($configuration);
    }

    public function testGetConfiguration()
    {
        $wrappedConfiguration = new Configuration(array(
            'wrapped' => array(
                'sampleData' => $this->getSampleData()
            ),
        ));

        $configuration = $wrappedConfiguration->getConfiguration('wrapped.sampleData');

        $this->runSampleDataTests($configuration);

        $this->setExpectedException('RuntimeException');

        $configuration = $wrappedConfiguration->getConfiguration('wrapped.sampleData.a');
    }

    public function testImport()
    {
        $configuration = new Configuration();
        $configuration->import($this->getSampleData());

        $this->runSampleDataTests($configuration);
    }

    public function testImportConfiguration()
    {
        $configuration = new Configuration();
        $configuration->importConfiguration(new Configuration($this->getSampleData()));

        $this->runSampleDataTests($configuration);
    }

    public function testExport()
    {
        $configuration = new Configuration($this->getSampleData());

        $this->assertEquals($this->getSampleData(), $configuration->export());
    }
}