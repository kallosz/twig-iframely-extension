<?php

namespace spec\KaLLoSz\Twig\Extension;

use KaLLoSz\Twig\Extension\IframelyDTO;
use PhpSpec\ObjectBehavior;

/**
 * Class IframelyDTOSpec
 * @package spec\KaLLoSz\Twig\Extension
 *
 * @author Patryk Kala <kkallosz@gmail.com>
 *
 * @mixin IframelyDTO
 */
class IframelyDTOSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(IframelyDTO::class);
    }

    function let()
    {
        $this->beConstructedWith([]);
    }
}
