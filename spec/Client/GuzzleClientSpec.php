<?php

namespace spec\KaLLoSz\Twig\Extension\Client;

use GuzzleHttp\ClientInterface;
use KaLLoSz\Twig\Extension\Client\GuzzleClient;
use KaLLoSz\Twig\Extension\IframelyClientInterface;
use KaLLoSz\Twig\Extension\IframelyDTO;
use PhpSpec\ObjectBehavior;
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
            IframelyClientInterface::API_URI,
            ['query' => ['api_key' => 'ApiKey', 'url' => 'http://example.com']]
        )->willReturn($response);

        $this->getUrlData('http://example.com')->shouldBeAnInstanceOf(IframelyDTO::class);
    }
}
