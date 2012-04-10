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
        $this->data = $data ?: array();
    }

    /**
     * {@inheritdoc}
     */
    public function append($key, $value = null)
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value = null)
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        $currentValue = $this->data;
        $keyPath = explode('.', $key);

        for ( $i = 0; $i < count($keyPath); $i++ ) {
            $currentKey = $keyPath[$i];
            if (!isset($currentValue[$currentKey]) ) { return null; }
            $currentValue = $currentValue[$currentKey];
        }

        return $currentValue;
    }

    /**
     * {@inheritdoc}
     */
    public function getData($key)
    {
        $value = $this->get($key);
        if (is_array($value) && Util::isAssoc($value)) {
            return new Data($value);
        }

        throw new \RuntimeException("Value at '$key' could not be represented as a DataInterface");
    }

    /**
     * {@inheritdoc}
     */
    public function import(array $data, $clobber = true)
    {
        $this->data = Util::mergeAssocArray($this->data, $data, $clobber);
    }

    /**
     * {@inheritdoc}
     */
    public function importData(DataInterface $data, $clobber = true)
    {
        $this->import($data->export(), $clobber);
    }

    /**
     * {@inheritdoc}
     */
    public function export()
    {
        return $this->data;
    }
}