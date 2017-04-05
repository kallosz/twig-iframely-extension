<?php

namespace spec\KaLLoSz\Twig\Extension\Cache;

use Doctrine\Common\Cache\ArrayCache;
use KaLLoSz\Twig\Extension\Cache\CacheInterface;
use KaLLoSz\Twig\Extension\Cache\DoctrineCacheBridge;
use PhpSpec\ObjectBehavior;

/**
 * Class DoctrineCacheBridgeSpec
 */
class DoctrineCacheBridgeSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new ArrayCache());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DoctrineCacheBridge::class);
    }

    function it_implements_cache_interface()
    {
        $this->shouldImplement(CacheInterface::class);
    }

    function it_save_element()
    {
        $id = sha1(get_class());
        $value = time();
        $this->get($id)->shouldReturn(false);
        $this->save($id, $value)->shouldReturn(true);
        $this->get($id)->shouldReturn($value);
    }

    function it_has_element()
    {
        $id = sha1(get_class());
        $value = time();
        $this->has($id)->shouldReturn(false);
        $this->save($id, $value);
        $this->has($id)->shouldReturn(true);
    }

    function it_delete_element()
    {
        $id = sha1(get_class());
        $value = time();
        $this->has($id)->shouldReturn(false);
        $this->save($id, $value);
        $this->has($id)->shouldReturn(true);
        $this->delete($id)->shouldReturn(true);
        $this->has($id)->shouldReturn(false);
    }
}
