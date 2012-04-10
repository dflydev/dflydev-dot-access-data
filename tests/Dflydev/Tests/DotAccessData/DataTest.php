<?php

/*
 * This file is a part of dflydev/dot-access-configuration.
 * 
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\Tests\DotAccessData;

use Dflydev\DotAccessData\Data;
use Dflydev\DotAccessData\DataInterface;

class DataTest extends \PHPUnit_Framework_TestCase
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

    protected function runSampleDataTests(DataInterface $configuration)
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
        $configuration = new Data($this->getSampleData());

        $this->runSampleDataTests($configuration);
    }

    public function testGetData()
    {
        $wrappedData = new Data(array(
            'wrapped' => array(
                'sampleData' => $this->getSampleData()
            ),
        ));

        $configuration = $wrappedData->getData('wrapped.sampleData');

        $this->runSampleDataTests($configuration);

        $this->setExpectedException('RuntimeException');

        $configuration = $wrappedData->getData('wrapped.sampleData.a');
    }

    public function testImport()
    {
        $configuration = new Data();
        $configuration->import($this->getSampleData());

        $this->runSampleDataTests($configuration);
    }

    public function testImportData()
    {
        $configuration = new Data();
        $configuration->importData(new Data($this->getSampleData()));

        $this->runSampleDataTests($configuration);
    }

    public function testExport()
    {
        $configuration = new Data($this->getSampleData());

        $this->assertEquals($this->getSampleData(), $configuration->export());
    }
}