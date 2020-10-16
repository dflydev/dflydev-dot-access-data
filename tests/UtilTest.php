<?php

declare(strict_types=1);

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
    public function testMergeAssocArray($message, $to, $from, $mode, $expectedResult)
    {
        if ($mode === null) {
            $result = Util::mergeAssocArray($to, $from);
        } else {
            $result = Util::mergeAssocArray($to, $from, $mode);
        }

        $this->assertEquals($expectedResult, $result, $message);
    }

    public function mergeAssocArrayProvider()
    {
        return [
            [
                'Overwrite should replace to value with from value for strings (shallow)',
                // to
                ['a' => 'A'],
                // from
                ['a' => 'B'],
                // mode
                DataInterface::REPLACE,
                // expected result
                ['a' => 'B'],
            ],

            [
                'Overwrite should replace to value with from value for strings (deep)',
                // to
                ['a' => ['b' => 'B']],
                // from
                ['a' => ['b' => 'C']],
                // mode
                DataInterface::REPLACE,
                // expected result
                ['a' => ['b' => 'C']]
            ],

            [
                'Existing values are not replaced in preserve mode (shallow)',
                // to
                ['a' => 'A'],
                // from
                ['a' => 'B'],
                // mode
                DataInterface::PRESERVE,
                // expected result
                ['a' => 'A'],
            ],

            [
                'Existing values are not replaced in preserve mode (deep)',
                // to
                ['a' => ['b' => 'B']],
                // from
                ['a' => ['b' => 'C']],
                // mode
                DataInterface::PRESERVE,
                // expected result
                ['a' => ['b' => 'B']],
            ],

            [
                'Associative arrays should be combined',
                // to
                ['a' => ['b' => 'B']],
                // from
                ['a' => ['c' => 'C']],
                // mode
                null,
                // expected result
                ['a' => ['b' => 'B', 'c' => 'C']],
            ],

            [
                'Arrays should be replaced',
                // to
                ['a' => ['b', 'c']],
                // from
                ['a' => ['B', 'C']],
                // mode
                DataInterface::REPLACE,
                // expected result
                ['a' => ['B', 'C']],
            ],

            [
                'Arrays should be preserved',
                // to
                ['a' => ['b', 'c']],
                // from
                ['a' => ['B', 'C']],
                // mode
                DataInterface::PRESERVE,
                // expected result
                ['a' => ['b', 'c']],
            ],

            [
                'Arrays should be merged/appended (when using MERGE)',
                // to
                ['a' => 1, 'b' => 1, 'n' => [1], 'x' => 'string', 'y' => ['stringindex' => 1]],
                // from
                ['a' => 2, 'c' => 2, 'n' => [2], 'x' => ['array'], 'y' => [2]],
                // mode
                DataInterface::MERGE,
                // expected result
                ['a' => 2, 'b' => 1, 'c' => 2, 'n' => [1, 2], 'x' => ['array'], 'y' => ['stringindex' => 1, 0 => 2]]
            ],
        ];
    }
}
