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
        $this->beConstructedWith(
            [
                'html' => 'html',
                'meta' => [
                    'author' => 'Jon Doe',
                ],
                'links' => [
                    'player' => [
                        [
                            'href' => 'http://example1.player',
                            'rel' => [],
                        ],
                        [
                            'href' => 'http://example2.player',
                            'rel' => ['autoplay'],
                        ]
                    ],
                ],
            ]
        );
    }

    function it_allow_to_get_meta()
    {
        $meta = $this->getMeta();
        $meta->shouldBeArray();
        $meta->shouldHaveKey('author');
        $meta->shouldContain('Jon Doe');
    }

    function it_allow_to_get_html()
    {
        $html = $this->getHTML();
        $html->shouldReturn('html');
    }

    function it_allow_to_get_links()
    {
        $links = $this->getLinks();
        $links->shouldBeArray();
        $links->shouldHaveKey('player');

        $players = $this->getLinks()['player'];
        $players->shouldBeArray();
        $players->shouldHaveCount(2);
    }

    function it_allow_to_get_first_player_href()
    {
        $player = $this->getFirstPlayerHref();
        $player->shouldReturn('http://example1.player');
    }

    function it_allow_to_get_href_with_autoplay_player()
    {
        $player = $this->getAutoplayPlayerHref();
        $player->shouldReturn('http://example2.player');
    }
    function it_should_return_null_if_autoplay_player_not_exists()
    {
        $this->beConstructedWith(['links' => ['player' => []]]);

        $player = $this->getAutoplayPlayerHref();
        $player->shouldReturn(null);
    }
}
