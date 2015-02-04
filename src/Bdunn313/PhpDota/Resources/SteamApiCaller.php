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
        $response = $this->client->get($this->constructUrl());
        return $response->json(['object' => true]);
    }

    /**
     * @param $endpoint_string
     * @return $this
     */
    public function endpoint($endpoint_string)
    {
        $this->endpoint = $this->fixEndpointString($endpoint_string);
        return $this;
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
    private function constructUrl()
    {
        if (!$this->endpoint)
            throw new \BadMethodCallException('You must provide an endpoint before attempting to make an API call.');
        return $this->base_url . ($this->endpoint ?: '') . $this->constructUrlParameters();
    }

    /**
     * @return string
     */
    private function constructUrlParameters()
    {
        $urlString = '?key=' . $this->api_key;
        if ($this->options)
            $urlString = $urlString . '&' . http_build_query($this->options);

        return $urlString;
    }

    /**
     * @param $endpoint_string
     * @return string
     */
    private function fixEndpointString($endpoint_string)
    {
        // To account for leading and trailing slashes.
        return preg_replace('/^\/?(\w+(\/\w+)+)\/?$/', '$1/', $endpoint_string);
    }
}
