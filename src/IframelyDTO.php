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
        return $this->data['meta'];
    }

    /**
     * @return array
     */
    public function getLinks(): array
    {
        return $this->data['links'];
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->data['html'];
    }
}
