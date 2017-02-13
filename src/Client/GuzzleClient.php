<?php

namespace KaLLoSz\Twig\Extension\Client;

use GuzzleHttp\ClientInterface;
use KaLLoSz\Twig\Extension\IframelyClientInterface;
use KaLLoSz\Twig\Extension\IframelyDTO;

class GuzzleClient implements IframelyClientInterface
{
    /**
     * @var null|string
     */
    private $apiKey;

    /**
     * @var ClientInterface
     */
    private $client;

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
     * {@inheritdoc}
     */
    public function getUrlData(string $url): IframelyDTO
    {
        $response = $this->client->request(
            'GET',
            IframelyClientInterface::API_URI,
            ['query' => ['api_key' => $this->apiKey, 'url' => $url]]
        );

        return new IframelyDTO(json_decode($response->getBody()->getContents(), true));
    }
}
