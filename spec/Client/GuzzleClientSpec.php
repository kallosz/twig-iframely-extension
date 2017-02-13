<?php

namespace spec\KaLLoSz\Twig\Extension\Client;

use GuzzleHttp\ClientInterface;
use KaLLoSz\Twig\Extension\Cache\CacheInterface;
use KaLLoSz\Twig\Extension\Client\GuzzleClient;
use KaLLoSz\Twig\Extension\IframelyClientInterface;
use KaLLoSz\Twig\Extension\IframelyDTO;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class GuzzleClientSpec
 * @package spec\KaLLoSz\Twig\Extension\Client
 *
 * @author Patryk Kala <kkallosz@gmail.com>
 *
 * @mixin GuzzleClient
 */
class GuzzleClientSpec extends ObjectBehavior
{
    function let(ClientInterface $client)
    {
        $this->beConstructedWith('ApiKey', $client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GuzzleClient::class);
    }

    function it_make_request_to_iframely_api(ClientInterface $client, ResponseInterface $response, StreamInterface $stream)
    {
        $stream->getContents()->willReturn('{}');
        $response->getBody()->willReturn($stream);

        $client->request(
            'GET',
            IframelyClientInterface::API_BASE_URI,
            ['query' => ['api_key' => 'ApiKey', 'url' => 'http://example.com', 'html' => 1]]
        )->willReturn($response);

        $this->getUrlData('http://example.com')->shouldBeAnInstanceOf(IframelyDTO::class);
    }

    function it_allow_to_save_dto_in_cache(CacheInterface $cache, ClientInterface $client, ResponseInterface $response, StreamInterface $stream)
    {
        $cache->has(CacheInterface::KEY_PREFIX.md5('http://example.com'))->willReturn(false);
        $cache->save(
            CacheInterface::KEY_PREFIX.md5('http://example.com'),
            Argument::type(IframelyDTO::class),
            CacheInterface::LIFETIME_DAY
        )->shouldBeCalled();

        $this->setCache($cache);

        $this->it_make_request_to_iframely_api($client, $response, $stream);
    }

    function it_allow_to_fetch_dto_from_cache(CacheInterface $cache, ClientInterface $client, IframelyDTO $iframelyDTO)
    {
        $cache->has(CacheInterface::KEY_PREFIX.md5('http://example.com'))->willReturn(true);
        $cache->get(CacheInterface::KEY_PREFIX.md5('http://example.com'))->willReturn($iframelyDTO);

        $this->setCache($cache);

        $client->request(Argument::any(), Argument::any(), Argument::any())->shouldNotBeCalled();

        $this->getUrlData('http://example.com')->shouldBeAnInstanceOf(IframelyDTO::class);
    }
}
