<?php

namespace App\Tests;

use App\Service\CalculateQuarterDeclaration;
use App\Util\CurrencyFormatter;

class CalculatorTest extends AppWebTestCase
{
    public function testEnvironment(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
    }

    public function testCalculateQuarter(): void
    {
        $this->logInAs();

        $container = static::getContainer();

        $calculateQuarterDeclaration = $container->get('test.'.CalculateQuarterDeclaration::class);

        $this->assertSame(30000, $calculateQuarterDeclaration->calculateForQuarter(4, 2021)->getAmount());
    }

    public function testCurrencyFormatter(): void
    {
        $container = static::getContainer();
        /** @var CurrencyFormatter $currencyFormatter */
        $currencyFormatter = $container->get('test.'.CurrencyFormatter::class);

        $this->assertSame(25.50, $currencyFormatter->toFloat(2550));

        $this->assertSame('25,50 €', trim($currencyFormatter->toCurrency(2550)));
    }
}
