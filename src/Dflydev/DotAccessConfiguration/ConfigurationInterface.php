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

interface ConfigurationInterface
{
    /**
     * Append a value to a key (assumes key refers to an array value)
     * 
     * @param string $key
     * @param mixed $value
     */
    public function append($key, $value = null);

    /**
     * Set a value for a key
     * 
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value = null);

    /**
     * Remove a key
     * 
     * @param string $key
     */
    public function remove($key);

    /**
     * Get the raw value for a key
     * 
     * @param string $key
     * @return mixed
     */
    public function get($key);

    /**
     * Get a configuration instance for a key
     * 
     * @param string $key
     * @return ConfigurationInterface
     */
    public function getConfiguration($key);

    /**
     * Import data into existing configuration
     * 
     * @param array $data
     * @param bool $clobber
     */
    public function importData(array $data, $clobber = true);

    /**
     * Import data from an external configuration into existing configuration
     * 
     * @param ConfigurationInterface $configuration
     * @param bool $clobber
     */
    public function importConfiguration(ConfigurationInterface $configuration, $clobber = true);

    /**
     * Export configuration as raw data
     * 
     * @return array
     */
    public function export();
}