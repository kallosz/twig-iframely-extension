<?php

namespace spec\KaLLoSz\Twig\Extension;

use KaLLoSz\Twig\Extension\IframelyClientInterface;
use KaLLoSz\Twig\Extension\IframelyDTO;
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
        $this->getFilters()->shouldHaveCount(1);
    }

    function it_should_contains_functions()
    {
        $this->getFunctions()->shouldHaveCount(1);
    }

    function it_should_have_name()
    {
        $this->getName()->shouldReturn('kallosz\twig-iframely-extension');
    }

    function it_should_return_dto_object(IframelyClientInterface $client, IframelyDTO $iframelyDTO)
    {
        $client->getUrlData('http://example.com')->willReturn($iframelyDTO);
        $this->getDTO('http://example.com')->shouldBeAnInstanceOf(IframelyDTO::class);
    }

    function it_should_return_embed_html(IframelyClientInterface $client, IframelyDTO $iframelyDTO)
    {
        $iframelyDTO->getHTML()->willReturn('<html>http://example.com</html>');
        $client->getUrlData('http://example.com')->willReturn($iframelyDTO);
        $this->getEmbedHtml('http://example.com')->shouldReturn('<html>http://example.com</html>');
    }
}
