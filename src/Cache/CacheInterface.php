<?php

namespace KaLLoSz\Twig\Extension\Cache;

/**
 * Interface CacheInterface
 * @package KaLLoSz\Twig\Extension\Cache
 */
interface CacheInterface
{
    const LIFETIME_DAY = 86400;
    const KEY_PREFIX = 'iframely.';

    /**
     * Fetch an entry from the cache.
     *
     * @param string $id
     * @return mixed|false
     */
    public function get($id);

    /**
     * Tests if an entry exists in the cache.
     *
     * @param string $id
     * @return boolean
     */
    public function has($id);

    /**
     * Puts data into the cache.
     *
     * @param string $id The cache id.
     * @param mixed $data The cache entry/data.
     * @param int $lifeTime The cache lifetime.
     *                         If != 0, sets a specific lifetime for this cache entry (0 => infinite lifeTime).
     *
     * @return boolean TRUE if the entry was successfully stored in the cache, FALSE otherwise.
     */
    public function save($id, $data, $lifeTime = 0);

    /**
     * Deletes a cache entry.
     *
     * @param string $id The cache id.
     *
     * @return boolean TRUE if the cache entry was successfully deleted, FALSE otherwise.
     */
    public function delete($id);
}
