<?php

/*
 * This file is a part of dflydev/dot-access-data.
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

    protected function runSampleDataTests(DataInterface $data)
    {
        $this->assertEquals('A', $data->get('a'));
        $this->assertEquals('B', $data->get('b.b'));
        $this->assertEquals(array('C1', 'C2', 'C3'), $data->get('b.c'));
        $this->assertEquals('D3', $data->get('b.d.d3'));
        $this->assertEquals(array('c1', 'c2', 'c3'), $data->get('c'));
        $this->assertEquals(null, $data->get('foo'), 'Foo should not exist');
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
        $data = new Data($this->getSampleData());

        $this->runSampleDataTests($data);
    }

    public function testGetData()
    {
        $wrappedData = new Data(array(
            'wrapped' => array(
                'sampleData' => $this->getSampleData()
            ),
        ));

        $data = $wrappedData->getData('wrapped.sampleData');

        $this->runSampleDataTests($data);

        $this->setExpectedException('RuntimeException');

        $data = $wrappedData->getData('wrapped.sampleData.a');
    }

    public function testImport()
    {
        $data = new Data();
        $data->import($this->getSampleData());

        $this->runSampleDataTests($data);
    }

    public function testImportData()
    {
        $data = new Data();
        $data->importData(new Data($this->getSampleData()));

        $this->runSampleDataTests($data);
    }

    public function testExport()
    {
        $data = new Data($this->getSampleData());

        $this->assertEquals($this->getSampleData(), $data->export());
    }
}