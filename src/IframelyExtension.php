<?php

namespace KaLLoSz\Twig\Extension;

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
    public function getDTO(string $url): IframelyDTO
    {
        return $this->client->getUrlData($url);
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public function getEmbedHTML(string $url): string
    {
        return $this->getDTO($url)->getHTML();
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('iframelyHTML', [$this, 'getEmbedHTML']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('iframely', [$this, 'getDTO']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'kallosz\twig-iframely-extension';
    }
}
