<?php

namespace App\Tests;

use App\Util\NumberSplitter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NumberSplitterTest extends KernelTestCase
{

    public function testSplitter(): void
    {
        $numberSplitter = new NumberSplitter();

        $this->assertSame([30000, 30000, 29900], $numberSplitter->splitRound(89900, 3));
        $this->assertSame([20000, 20000, 20000, 20000, 19900], $numberSplitter->splitRound(99900, 5));
        $this->assertSame([24900, 24900, 24900, 24900], $numberSplitter->splitRound(99600, 4));
        $this->assertSame([8500, 8500, 8500], $numberSplitter->splitRound(25500, 3));
        $this->assertSame([1000, 1000, 999], $numberSplitter->splitRound(2999, 3));
        $this->assertSame([999, 999, 997], $numberSplitter->splitRound(2995, 3));
    }
}
