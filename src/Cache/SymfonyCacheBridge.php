<?php

namespace KaLLoSz\Twig\Extension\Cache;

use Symfony\Component\Cache\Adapter\AdapterInterface;

/**
 * Class SymfonyCacheBridge
 * @package KaLLoSz\Twig\Extension\Cache
 *
 * @author Patryk Kala <kkallosz@gmail.com>
 */
class SymfonyCacheBridge implements CacheInterface
{
    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        $item = $this->adapter->getItem($id);
        if ($item->isHit()) {
            return $item->get();
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function has($id)
    {
        $item = $this->adapter->getItem($id);

        return $item->isHit();
    }

    /**
     * {@inheritdoc}
     */
    public function save($id, $data, $lifeTime = 0)
    {
        $item = $this->adapter->getItem($id);
        $item->set($data);

        if ($lifeTime > 0) {
            $item->expiresAfter($lifeTime);
        }

        return $this->adapter->save($item);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($id)
    {
        $item = $this->adapter->getItem($id);

        return $this->adapter->deleteItem($item);
    }
}
