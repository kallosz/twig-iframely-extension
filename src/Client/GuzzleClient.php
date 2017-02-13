<?php

namespace KaLLoSz\Twig\Extension\Client;

use GuzzleHttp\ClientInterface;
use KaLLoSz\Twig\Extension\Cache\CacheInterface;
use KaLLoSz\Twig\Extension\IframelyClientInterface;
use KaLLoSz\Twig\Extension\IframelyDTO;

/**
 * Class GuzzleClient
 * @package KaLLoSz\Twig\Extension\Client
 *
 * @author Patryk Kala <kkallosz@gmail.com>
 */
class GuzzleClient implements IframelyClientInterface
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var CacheInterface|null
     */
    private $cache = null;

    /**
     * Class constructor.
     *
     * @param string|null $apiKey API key.
     * @param ClientInterface $client Guzzle Client
     */
    public function __construct(string $apiKey, ClientInterface $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }

    /**
     * @param CacheInterface $cache
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrlData(string $url): IframelyDTO
    {
        if ($this->cache && $this->cache->has(CacheInterface::KEY_PREFIX.md5($url))) {
            return $this->cache->get(CacheInterface::KEY_PREFIX.md5($url));
        }

        $response = $this->client->request(
            'GET',
            IframelyClientInterface::API_BASE_URI,
            ['query' => ['api_key' => $this->apiKey, 'url' => $url, 'html' => 1]]
        );

        $dto = new IframelyDTO(json_decode($response->getBody()->getContents(), true));

        if ($this->cache) {
            $this->cache->save(CacheInterface::KEY_PREFIX.md5($url), $dto, CacheInterface::LIFETIME_DAY);
        }

        return $dto;
    }
}
