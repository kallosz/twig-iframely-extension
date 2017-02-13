<?php

namespace KaLLoSz\Twig\Extension;

/**
 * Interface IframelyClientInterface
 * @package KaLLoSz\Twig\Extension
 */
interface IframelyClientInterface
{
    const API_URI = 'http://iframe.ly/api/iframely';

    /**
     * @param string $url
     *
     * @return IframelyDTO
     */
    public function getUrlData(string $url): IframelyDTO;
}
