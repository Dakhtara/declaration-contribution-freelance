<?php

namespace App\Tests;

use App\Entity\Transaction;
use App\Service\CalculateQuarterDeclaration;
use App\SummaryQuarter\SummaryQuarter;
use App\Util\CurrencyFormatter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CalculatorTest extends KernelTestCase
{
    public function testEnvironment(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        //$routerService = self::$container->get('router');
        //$myCustomService = self::$container->get(CustomService::class);
    }

    public function testCalculateQuarterMock(): void
    {
        $kernel = self::bootKernel();

        $mock = $this->createMock(CalculateQuarterDeclaration::class);

        $transactions = [
            (new Transaction())->setType(Transaction::TYPE_DEBIT)->setPrice(20000)->setDateTime(new \DateTime('-2 days')),
            (new Transaction())->setType(Transaction::TYPE_CREDIT)->setPrice(70000)->setDateTime(new \DateTime('-1 days')),
        ];

        $mock->method('calculateForQuarter')
            ->willReturn(new SummaryQuarter($transactions));

        $this->assertInstanceOf(SummaryQuarter::class, $mock->calculateForQuarter($transactions, new \DateTime()));
    }

    public function testCalculateQuarter(): void
    {
        $container = static::getContainer();

        $calculateQuarterDeclaration = $container->get('test.' . CalculateQuarterDeclaration::class);
        $transactions = [
            (new Transaction())->setType(Transaction::TYPE_DEBIT)->setPrice(20000)->setDateTime(new \DateTime('-2 days')),
            (new Transaction())->setType(Transaction::TYPE_CREDIT)->setPrice(70000)->setDateTime(new \DateTime('-1 days')),
            (new Transaction())->setType(Transaction::TYPE_DEBIT)->setPrice(60000)->setDateTime(new \DateTime('-1 days'))->setSlices(3)
        ];
        $this->assertSame(30000, $calculateQuarterDeclaration->calculate($transactions));
    }

    public function testCurrencyFormatter(): void
    {
        $container = static::getContainer();
        /** @var CurrencyFormatter $currencyFormatter */
        $currencyFormatter = $container->get('test.' . CurrencyFormatter::class);

        $this->assertSame(25.50, $currencyFormatter->toFloat(2550));

        $this->assertSame("25,50 €", trim($currencyFormatter->toCurrency(2550)));
    }

}
