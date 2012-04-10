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

class Configuration implements ConfigurationInterface
{
    /**
     * Internal representation of configuration data
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
    public function getConfiguration($key)
    {
        $value = $this->get($key);
        if (is_array($value) && Util::isAssoc($value)) {
            return new Configuration($value);
        }

        throw new \RuntimeException("Value at '$key' could not be represented as a ConfigurationInterface");
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
    public function importConfiguration(ConfigurationInterface $configuration, $clobber = true)
    {
        $this->import($configuration->export(), $clobber);
    }

    /**
     * {@inheritdoc}
     */
    public function export()
    {
        return $this->data;
    }
}