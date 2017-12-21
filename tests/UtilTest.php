<?php

/*
 * This file is a part of dflydev/dot-access-data.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\DotAccessData;

use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{
    public function testIsAssoc()
    {
        $this->assertTrue(Util::isAssoc(['a' => 'A']));
        $this->assertTrue(Util::isAssoc([]));
        $this->assertFalse(Util::isAssoc([1 => 'One']));
    }

    /**
     * @dataProvider mergeAssocArrayProvider
     */
    public function testMergeAssocArray($message, $to, $from, $clobber, $expectedResult)
    {
        $result = Util::mergeAssocArray($to, $from, $clobber);
        $this->assertEquals($expectedResult, $result, $message);
    }

    public function mergeAssocArrayProvider()
    {
        return [
            [
                'Clobber should replace to value with from value for strings (shallow)',
                // to
                ['a' => 'A'],
                // from
                ['a' => 'B'],
                // clobber
                true,
                // expected result
                ['a' => 'B'],
            ],

            [
                'Clobber should replace to value with from value for strings (deep)',
                // to
                ['a' => ['b' => 'B']],
                // from
                ['a' => ['b' => 'C']],
                // clobber
                true,
                // expected result
                ['a' => ['b' => 'C']]
            ],

            [
                'Clobber should  NOTreplace to value with from value for strings (shallow)',
                // to
                ['a' => 'A'],
                // from
                ['a' => 'B'],
                // clobber
                false,
                // expected result
                ['a' => 'A'],
            ],

            [
                'Clobber should NOT replace to value with from value for strings (deep)',
                // to
                ['a' => ['b' => 'B']],
                // from
                ['a' => ['b' => 'C']],
                // clobber
                false,
                // expected result
                ['a' => ['b' => 'B']],
            ],

            [
                'Associative arrays should be combined',
                // to
                ['a' => ['b' => 'B']],
                // from
                ['a' => ['c' => 'C']],
                // clobber
                null,
                // expected result
                ['a' => ['b' => 'B', 'c' => 'C']],
            ],

            [
                'Arrays should be replaced (with clobber enabled)',
                // to
                ['a' => ['b', 'c']],
                // from
                ['a' => ['B', 'C']],
                // clobber
                true,
                // expected result
                ['a' => ['B', 'C']],
            ],

            [
                'Arrays should be NOT replaced (with clobber disabled)',
                // to
                ['a' => ['b', 'c']],
                // from
                ['a' => ['B', 'C']],
                // clobber
                false,
                // expected result
                ['a' => ['b', 'c']],
            ],
        ];
    }
}
