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

use RuntimeException;

class Data implements DataInterface
{
    /**
     * Internal representation of data data
     *
     * @var array
     */
    protected $data;

    /**
     * Constructor
     *
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        $this->data = $data ?: [];
    }

    /**
     * {@inheritdoc}
     */
    public function append(string $key, $value = null)
    {
        if (0 == strlen($key)) {
            throw new RuntimeException("Key cannot be an empty string");
        }

        $currentValue =& $this->data;
        $keyPath = explode('.', $key);

        if (1 == count($keyPath)) {
            if (!isset($currentValue[$key])) {
                $currentValue[$key] = [];
            }
            if (!is_array($currentValue[$key])) {
                // Promote this key to an array.
                // TODO: Is this really what we want to do?
                $currentValue[$key] = [$currentValue[$key]];
            }
            $currentValue[$key][] = $value;

            return;
        }

        $endKey = array_pop($keyPath);
        for ( $i = 0; $i < count($keyPath); $i++ ) {
            $currentKey =& $keyPath[$i];
            if ( ! isset($currentValue[$currentKey]) ) {
                $currentValue[$currentKey] = [];
            }
            $currentValue =& $currentValue[$currentKey];
        }

        if (!isset($currentValue[$endKey])) {
            $currentValue[$endKey] = [];
        }
        if (!is_array($currentValue[$endKey])) {
            $currentValue[$endKey] = [$currentValue[$endKey]];
        }
        // Promote this key to an array.
        // TODO: Is this really what we want to do?
        $currentValue[$endKey][] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $key, $value = null)
    {
        if (0 == strlen($key)) {
            throw new RuntimeException("Key cannot be an empty string");
        }

        $currentValue =& $this->data;
        $keyPath = explode('.', $key);

        if (1 == count($keyPath)) {
            $currentValue[$key] = $value;

            return;
        }

        $endKey = array_pop($keyPath);
        for ( $i = 0; $i < count($keyPath); $i++ ) {
            $currentKey =& $keyPath[$i];
            if (!isset($currentValue[$currentKey])) {
                $currentValue[$currentKey] = [];
            }
            if (!is_array($currentValue[$currentKey])) {
                throw new RuntimeException("Key path at $currentKey of $key cannot be indexed into (is not an array)");
            }
            $currentValue =& $currentValue[$currentKey];
        }
        $currentValue[$endKey] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(string $key)
    {
        if (0 == strlen($key)) {
            throw new RuntimeException("Key cannot be an empty string");
        }

        $currentValue =& $this->data;
        $keyPath = explode('.', $key);

        if (1 == count($keyPath)) {
            unset($currentValue[$key]);

            return;
        }

        $endKey = array_pop($keyPath);
        for ( $i = 0; $i < count($keyPath); $i++ ) {
            $currentKey =& $keyPath[$i];
            if (!isset($currentValue[$currentKey])) {
                return;
            }
            $currentValue =& $currentValue[$currentKey];
        }
        unset($currentValue[$endKey]);
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key, $default = null)
    {
        $currentValue = $this->data;
        $keyPath = explode('.', $key);

        for ( $i = 0; $i < count($keyPath); $i++ ) {
            $currentKey = $keyPath[$i];
            if (!isset($currentValue[$currentKey]) ) {
                return $default;
            }
            if (!is_array($currentValue)) {
                return $default;
            }
            $currentValue = $currentValue[$currentKey];
        }

        return $currentValue === null ? $default : $currentValue;
    }

    /**
     * {@inheritdoc}
     */
    public function has(string $key): bool
    {
        $currentValue = &$this->data;
        $keyPath = explode('.', $key);

        for ( $i = 0; $i < count($keyPath); $i++ ) {
            $currentKey = $keyPath[$i];
            if (
                !is_array($currentValue) ||
                !array_key_exists($currentKey, $currentValue)
            ) {
                return false;
            }
            $currentValue = &$currentValue[$currentKey];
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(string $key): DataInterface
    {
        $value = $this->get($key);
        if (is_array($value) && Util::isAssoc($value)) {
            return new Data($value);
        }

        throw new RuntimeException("Value at '$key' could not be represented as a DataInterface");
    }

    /**
     * {@inheritdoc}
     */
    public function import(array $data, bool $clobber = true)
    {
        $this->data = Util::mergeAssocArray($this->data, $data, $clobber);
    }

    /**
     * {@inheritdoc}
     */
    public function importData(DataInterface $data, bool $clobber = true)
    {
        $this->import($data->export(), $clobber);
    }

    /**
     * {@inheritdoc}UtilTest.php
     */
    public function export(): array
    {
        return $this->data;
    }
}
