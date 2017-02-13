<?php

namespace KaLLoSz\Twig\Extension;

use Psr\Http\Message\ResponseInterface;

/**
 * Class IframelyExtension
 * @package KaLLoSz\Twig\Extension
 *
 * @author Patryk Kala <kkallosz@gmail.com>
 */
class IframelyExtension extends \Twig_Extension
{
    /**
     * @var IframelyClientInterface
     */
    protected $client;

    /**
     * @param IframelyClientInterface $client Iframely Client
     */
    public function __construct(IframelyClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $url
     *
     * @return IframelyDTO
     */
    private function getDataFromApi(string $url): IframelyDTO
    {
        return $this->client->getUrlData($url);
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public function getEmbedUrl(string $url): string
    {
        return $this->getDataFromApi($url);
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public function getEmbedHtml(string $url): string
    {
        return $this->getDataFromApi($url)->getHtml();
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('iframelyUrl', [$this, 'getEmbedUrl']),
            new \Twig_SimpleFilter('iframelyHtml', [$this, 'getEmbedHtml']),
        ];
    }

    public function getName()
    {
        return 'kallosz\twig-iframely-extension';
    }
}
