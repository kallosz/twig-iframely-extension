<?php

namespace KaLLoSz\Twig\Extension;

/**
 * Class IframelyDTO
 * @package KaLLoSz\Twig\Extension
 *
 * @author Patryk Kala <kkallosz@gmail.com>
 */
class IframelyDTO
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Build IframelyDTO object base on iframely schema
     * (http://iframe.ly/api/iframely?url=http://iframe.ly/ACcM3Y)
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getMeta(): array
    {
        return $this->data['meta'] ?? [];
    }

    /**
     * @return string
     */
    public function getHTML(): string
    {
        return $this->data['html'] ?? '';
    }

    /**
     * @return string
     */
    public function getFirstPlayerHref(): string
    {
        return $this->getLinks()['player'][0]['href'] ?? '';
    }

    /**
     * @return null|string
     */
    public function getAutoplayPlayerHref()
    {
        $players = $this->getLinks()['player'] ?? [];

        foreach ($players as $player) {
            if (in_array('autoplay', $player['rel'])) {
                return $player['href'];
            }
        }

        return null;
    }

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->data['links'] ?? [];
    }
}
