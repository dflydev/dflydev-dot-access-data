<?php

/*
 * This file is a part of dflydev/dot-access-configuration.
 * 
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Dflydev\DotAccessConfiguration;

class Util
{
    /**
     * Merge contents from one associtative array to another
     * 
     * @param array $to
     * @param array $from
     * @param bool $clobber
     */
    static public function mergeAssocArray($to, $from, $clobber = true)
    {
        if ( is_array($from) ) {
            foreach ( $from as $k => $v ) {
                if (!isset($to[$k])) {
                    $to[$k] = $v;
                } else {
                    $to[$k] = self::mergeAssocArray($to[$k], $v, $clobber);
                }
            }
            return $to;
        }
        return $clobber ? $from : $to;
    }
}