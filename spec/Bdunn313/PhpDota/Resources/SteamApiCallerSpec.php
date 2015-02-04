<?php

namespace spec\Bdunn313\PhpDota\Resources;

use GuzzleHttp\ClientInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SteamApiCallerSpec extends ObjectBehavior
{

    protected $test_key = 'apiTESTkey';

    protected $test_base_url = 'https://api.steampowered.com/';

    function let(ClientInterface $client)
    {
        $this->beConstructedWith($this->test_key, $this->test_base_url, $client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bdunn313\PhpDota\Resources\SteamApiCaller');
    }

    function it_can_construct_the_basic_endpoint_url_with_an_api_key(ClientInterface $client)
    {
        $client->get($this->test_base_url . '?key=' . $this->test_key)
            ->shouldBeCalled();

        $this->get();
    }

    function it_can_construct_urls_with_different_endpoints(ClientInterface $client)
    {
        // Url #1
        $expectedUrl = $this->test_base_url . 'IDOTA2Match_570/GetMatchHistory/v001/?key=' . $this->test_key;
        $client->get($expectedUrl)->shouldBeCalled(4);

        $this->endpoint('IDOTA2Match_570/GetMatchHistory/v001')->get();
        $this->endpoint('IDOTA2Match_570/GetMatchHistory/v001/')->get();
        $this->endpoint('/IDOTA2Match_570/GetMatchHistory/v001/')->get();
        $this->endpoint('/IDOTA2Match_570/GetMatchHistory/v001')->get();

        // Url #2
        $expectedUrl = $this->test_base_url . 'IDOTA2Match_570/GetMatchDetails/v001/?key=' . $this->test_key;
        $client->get($expectedUrl)->shouldBeCalled(4);

        $this->endpoint('IDOTA2Match_570/GetMatchDetails/v001')->get();
        $this->endpoint('IDOTA2Match_570/GetMatchDetails/v001/')->get();
        $this->endpoint('/IDOTA2Match_570/GetMatchDetails/v001/')->get();
        $this->endpoint('/IDOTA2Match_570/GetMatchDetails/v001')->get();
    }

    function it_can_construct_urls_with_parameters(ClientInterface $client)
    {
        $params = 'key=' . $this->test_key . '&hero_id=12345&skill=2';
        $expectedUrl = $this->test_base_url . 'IDOTA2Match_570/GetMatchDetails/v001/?' . $params;

        $client->get($expectedUrl)->shouldBeCalled();

        $this->endpoint('IDOTA2Match_570/GetMatchDetails/v001')
            ->options(['hero_id' => 12345, 'skill' => 2])
            ->get();
    }
}
