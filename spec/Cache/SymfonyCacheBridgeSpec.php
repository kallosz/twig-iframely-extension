<?php

namespace spec\KaLLoSz\Twig\Extension\Cache;

use KaLLoSz\Twig\Extension\Cache\CacheInterface;
use KaLLoSz\Twig\Extension\Cache\SymfonyCacheBridge;
use PhpSpec\ObjectBehavior;
use Psr\Cache\CacheItemInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

/**
 * Class SymfonyCacheBridgeSpec
 */
class SymfonyCacheBridgeSpec extends ObjectBehavior
{
    function let(ArrayAdapter $adapter)
    {
        $this->beConstructedWith($adapter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SymfonyCacheBridge::class);
    }

    function it_implements_cache_interface()
    {
        $this->shouldImplement(CacheInterface::class);
    }

    function it_save_element(ArrayAdapter $adapter, CacheItemInterface $cacheItem)
    {
        $id = sha1(get_class());
        $value = time();

        $adapter->getItem($id)->shouldBeCalled()->willReturn($cacheItem);
        $adapter->save($cacheItem)->shouldBeCalled()->willReturn(true);
        $cacheItem->set($value)->shouldBeCalled();
        $cacheItem->expiresAfter(10)->shouldBeCalled();

        $this->save($id, $value, 10)->shouldReturn(true);
    }

    function it_return_element(ArrayAdapter $adapter, CacheItemInterface $cacheItem, CacheItemInterface $cacheItem2)
    {
        $id = sha1(get_class());
        $idNonExisting = sha1('nonexisting');
        $value = time();

        $adapter->getItem($id)->shouldBeCalled()->willReturn($cacheItem);
        $adapter->getItem($idNonExisting)->shouldBeCalled()->willReturn($cacheItem2);
        $cacheItem->isHit()->shouldBeCalled()->willReturn(true);
        $cacheItem->get()->willReturn($value);
        $cacheItem2->isHit()->shouldBeCalled()->willReturn(false);

        $this->get($id)->shouldReturn($value);
        $this->get($idNonExisting)->shouldReturn(false);

    }

    function it_has_element(ArrayAdapter $adapter, CacheItemInterface $cacheItem)
    {
        $id = sha1(get_class());

        $adapter->getItem($id)->shouldBeCalled()->willReturn($cacheItem);
        $cacheItem->isHit()->shouldBeCalled()->willReturn(true);

        $this->has($id)->shouldReturn(true);
    }

    function it_delete_element(ArrayAdapter $adapter, CacheItemInterface $cacheItem)
    {
        $id = sha1(get_class());

        $adapter->getItem($id)->willReturn($cacheItem);
        $adapter->deleteItem($cacheItem)->shouldBeCalled()->willReturn(true);

        $this->delete($id)->shouldReturn(true);
    }
}
