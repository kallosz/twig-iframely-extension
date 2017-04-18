<?php

namespace KaLLoSz\Twig\Extension\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use KaLLoSz\Twig\Extension\Cache\CacheInterface;
use KaLLoSz\Twig\Extension\IframelyClientInterface;
use KaLLoSz\Twig\Extension\IframelyDTO;
use Psr\Log\LoggerInterface;

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
     * @var LoggerInterface|null
     */
    private $logger = null;

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
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrlData(string $url): IframelyDTO
    {
        if ($this->cache && $this->cache->has(CacheInterface::KEY_PREFIX.md5($url))) {
            $this->addLog(LOG_INFO, 'Data returned from cache.');

            return $this->cache->get(CacheInterface::KEY_PREFIX.md5($url));
        }

        try {
            $response = $this->client->request(
                'GET',
                IframelyClientInterface::API_BASE_URI,
                ['query' => ['api_key' => $this->apiKey, 'url' => $url, 'html' => 1]]
            );

            $dto = new IframelyDTO(json_decode($response->getBody()->getContents(), true));
        } catch (GuzzleException $exception) {
            $this->addLog(LOG_ERR, $exception->getMessage());

            return new IframelyDTO([]);
        }

        if ($this->cache) {
            $this->cache->save(CacheInterface::KEY_PREFIX.md5($url), $dto, CacheInterface::LIFETIME_DAY);
            $this->addLog(LOG_INFO, 'Cache saved');
        }

        return $dto;
    }

    /**
     * @param $level
     * @param string $message
     */
    private function addLog($level, string $message)
    {
        if (!$this->logger) {
            return;
        }

        $this->logger->log($level, $message);
    }
}
