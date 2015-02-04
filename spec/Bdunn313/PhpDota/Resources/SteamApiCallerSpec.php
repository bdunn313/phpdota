<?php

namespace spec\Bdunn313\PhpDota\Resources;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\ResponseInterface;
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

    function it_can_construct_urls_with_different_endpoints(ClientInterface $client, ResponseInterface $response)
    {
        // Url #1
        $expectedUrl = $this->test_base_url . 'IDOTA2Match_570/GetMatchHistory/v001/?key=' . $this->test_key;
        $client->get($expectedUrl)->shouldBeCalled(4)->willReturn($response);

        $this->endpoint('IDOTA2Match_570/GetMatchHistory/v001')->get();
        $this->endpoint('IDOTA2Match_570/GetMatchHistory/v001/')->get();
        $this->endpoint('/IDOTA2Match_570/GetMatchHistory/v001/')->get();
        $this->endpoint('/IDOTA2Match_570/GetMatchHistory/v001')->get();

        // Url #2
        $expectedUrl = $this->test_base_url . 'IDOTA2Match_570/GetMatchDetails/v001/?key=' . $this->test_key;
        $client->get($expectedUrl)->shouldBeCalled(4)->willReturn($response);

        $this->endpoint('IDOTA2Match_570/GetMatchDetails/v001')->get();
        $this->endpoint('IDOTA2Match_570/GetMatchDetails/v001/')->get();
        $this->endpoint('/IDOTA2Match_570/GetMatchDetails/v001/')->get();
        $this->endpoint('/IDOTA2Match_570/GetMatchDetails/v001')->get();
    }

    function it_can_construct_urls_with_parameters(ClientInterface $client, ResponseInterface $response)
    {
        $params = 'key=' . $this->test_key . '&hero_id=12345&skill=2';
        $expectedUrl = $this->test_base_url . 'IDOTA2Match_570/GetMatchDetails/v001/?' . $params;

        $client->get($expectedUrl)->shouldBeCalled()->willReturn($response);

        $this->endpoint('IDOTA2Match_570/GetMatchDetails/v001')
            ->options(['hero_id' => 12345, 'skill' => 2])
            ->get();
    }

    function it_should_return_results_as_an_object(ClientInterface $client, ResponseInterface $response)
    {
        $params = 'key=' . $this->test_key . '&hero_id=12345&skill=2';
        $expectedUrl = $this->test_base_url . 'IDOTA2Match_570/GetMatchDetails/v001/?' . $params;

        $responseReturn = json_decode('{"result": {"status": 1, "num_results": 0, "total_results": 407, "results_remaining": 307} }');
        $response->json(['object'=>true])->shouldBeCalled()->willReturn($responseReturn);
        $client->get($expectedUrl)->shouldBeCalled()->willReturn($response);

        $this->endpoint('IDOTA2Match_570/GetMatchDetails/v001')
            ->options(['hero_id' => 12345, 'skill' => 2])
            ->get()
            ->shouldReturn($responseReturn);
    }

    function it_should_fail_if_no_endpoint_is_passed(ClientInterface $client, ResponseInterface $response)
    {
        $badUrl = $this->test_base_url . '?key=' . $this->test_key;
        $client->get($badUrl)->shouldNotBeCalled()->willReturn($response);

        $this->shouldThrow(new \BadMethodCallException('You must provide an endpoint before attempting to make an API call.'))
            ->duringGet();
    }
}
