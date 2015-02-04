<?php

namespace spec\Bdunn313\PhpDota\Resources;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MatchHistorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Bdunn313\PhpDota\Resources\MatchHistory');
    }
}
