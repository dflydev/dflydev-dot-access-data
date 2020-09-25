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

use Dflydev\DotAccessData\Exception\DataException;
use Dflydev\DotAccessData\Exception\InvalidPathException;

interface DataInterface
{
    /**
     * Append a value to a key (assumes key refers to an array value)
     *
     * @param string $key
     * @param mixed  $value
     *
     * @throws InvalidPathException if the given path is empty
     */
    public function append(string $key, $value = null): void;

    /**
     * Set a value for a key
     *
     * @param string $key
     * @param mixed  $value
     *
     * @throws InvalidPathException if the given path is empty
     * @throws DataException if the given path does not target an array
     */
    public function set(string $key, $value = null): void;

    /**
     * Remove a key
     *
     * @param string $key
     *
     * @throws InvalidPathException if the given path is empty
     */
    public function remove(string $key): void;

    /**
     * Get the raw value for a key
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     *
     * @psalm-mutation-free
     */
    public function get(string $key, $default = null);

    /**
     * Check if the key exists
     *
     * @param string $key
     *
     * @return bool
     *
     * @psalm-mutation-free
     */
    public function has(string $key): bool;

    /**
     * Get a data instance for a key
     *
     * @param string $key
     *
     * @return DataInterface
     *
     * @throws DataException if the given path does not reference an array
     *
     * @psalm-mutation-free
     */
    public function getData(string $key): DataInterface;

    /**
     * Import data into existing data
     *
     * @param array<string, mixed> $data
     * @param bool                 $clobber
     */
    public function import(array $data, bool $clobber = true): void;

    /**
     * Import data from an external data into existing data
     *
     * @param DataInterface $data
     * @param bool          $clobber
     */
    public function importData(DataInterface $data, bool $clobber = true): void;

    /**
     * Export data as raw data
     *
     * @return array<string, mixed>
     *
     * @psalm-mutation-free
     */
    public function export(): array;
}
