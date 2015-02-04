<?php

namespace Bdunn313\PhpDota\Resources;

use GuzzleHttp\ClientInterface;

class SteamApiCaller
{

    /**
     * @var
     */
    protected $endpoint;
    /**
     * @var
     */
    protected $options;
    /**
     * @var
     */
    private $api_key;
    /**
     * @var ClientInterface
     */
    private $client;
    /**
     * @var
     */
    private $base_url;

    /**
     * @param $api_key
     * @param $base_url
     * @param ClientInterface $client
     */
    public function __construct($api_key, $base_url, ClientInterface $client)
    {
        $this->api_key = $api_key;
        $this->client = $client;
        $this->base_url = $base_url;
    }

    /**
     *
     */
    public function get()
    {
        $this->client->get($this->constructUrl());
    }

    /**
     * @param $endpoint_string
     * @return $this
     */
    public function endpoint($endpoint_string)
    {
        if (mb_substr($endpoint_string, -1, 1) !== '/')
        {
            $endpoint_string = $endpoint_string . '/';
        }
        if (mb_substr($endpoint_string, 0, 1) === '/')
        {
            $endpoint_string = mb_substr($endpoint_string, 1);
        }
        $this->endpoint = $endpoint_string;
        return $this;
    }

    /**
     * @return string
     */
    private function constructUrl()
    {
        return $this->base_url . ($this->endpoint ?: '') . $this->constructUrlParameters();
    }

    /**
     * @param array $options
     * @return $this
     */
    public function options(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return string
     */
    private function constructUrlParameters()
    {
        $urlString = '?key=' . $this->api_key;
        if ($this->options)
        {
            $urlString = $urlString . '&' . http_build_query($this->options);
        }

        return $urlString;
    }
}
