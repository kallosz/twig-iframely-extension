<?php

namespace spec\KaLLoSz\Twig\Extension;

use KaLLoSz\Twig\Extension\IframelyClientInterface;
use KaLLoSz\Twig\Extension\IframelyExtension;
use PhpSpec\ObjectBehavior;

/**
 * Class IframelyExtensionSpec
 * @package spec\KaLLoSz\Twig\Extension
 *
 * @author Patryk Kala <kkallosz@gmail.com>
 *
 * @mixin IframelyExtension
 */
class IframelyExtensionSpec extends ObjectBehavior
{
    function let(IframelyClientInterface $client)
    {
        $this->beConstructedWith($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(IframelyExtension::class);
        $this->shouldImplement(\Twig_Extension::class);
    }

    function it_should_contains_filters()
    {
        $this->getFilters()->shouldHaveCount(2);
    }

    function it_should_have_name()
    {
        $this->getName()->shouldReturn('kallosz\twig-iframely-extension');
    }
}
