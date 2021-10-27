<?php

namespace App\Tests;

use App\Entity\Transaction;
use App\Service\CalculateQuarterDeclaration;
use App\SummaryQuarter\SummaryQuarter;
use App\Util\CurrencyFormatter;
use App\Util\QuarterDate;
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
            new Transaction(Transaction::TYPE_DEBIT, 20000, new \DateTime('-2 days')),
            new Transaction(Transaction::TYPE_CREDIT, 70000, new \DateTime('-1 days')),
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
            new Transaction(Transaction::TYPE_DEBIT, 20000, new \DateTime('-2 days')),
            new Transaction(Transaction::TYPE_CREDIT, 70000, new \DateTime('-1 days')),
        ];
        $this->assertSame(50000, $calculateQuarterDeclaration->calculate($transactions));
    }

    public function testCurrencyFormatter(): void
    {
        $container = static::getContainer();
        /** @var CurrencyFormatter $currencyFormatter */
        $currencyFormatter = $container->get('test.' . CurrencyFormatter::class);

        $this->assertSame(25.50, $currencyFormatter->toFloat(2550));

        $this->assertSame("25,50 €", trim($currencyFormatter->toCurrency(2550)));
    }

    public function testQuarterDate(): void
    {
        $container = static::getContainer();

        /** @var QuarterDate $quarterDate */
        $quarterDate = $container->get('test.'.QuarterDate::class);

        $tests = [
            [
                'date' => \DateTime::createFromFormat('d/m/Y H:i:s', '07/01/2021 16:31:24'),
                'expectedFirstDay' => '01/01/2021 00:00:00',
                'expectedLastDay' => '31/03/2021 23:59:59'
            ],
            [
                'date' => \DateTime::createFromFormat('d/m/Y H:i:s', '01/05/2021 16:31:24'),
                'expectedFirstDay' => '01/04/2021 00:00:00',
                'expectedLastDay' => '30/06/2021 23:59:59'
            ],
            [
                'date' => \DateTime::createFromFormat('d/m/Y H:i:s', '01/07/2021 16:31:24'),
                'expectedFirstDay' => '01/07/2021 00:00:00',
                'expectedLastDay' => '30/09/2021 23:59:59'
            ],
            [
                'date' => \DateTime::createFromFormat('d/m/Y H:i:s', '27/10/2021 16:31:24'),
                'expectedFirstDay' => '01/10/2021 00:00:00',
                'expectedLastDay' => '31/12/2021 23:59:59'
            ]
        ];

        foreach ($tests as $test) {
            $this->quarterDate($test, $quarterDate);
        }
    }

    private function quarterDate(array $test, QuarterDate $quarterDate)
    {
        $firstDay = $quarterDate->getFirstDayOfQuarter($test['date']);
        $this->assertInstanceOf(\DateTimeInterface::class, $firstDay);
        $this->assertSame($test['expectedFirstDay'], $firstDay->format('d/m/Y H:i:s'));

        $lastDay = $quarterDate->getLastDayOfQuarter($test['date']);
        $this->assertInstanceOf(\DateTimeInterface::class, $lastDay);
        $this->assertSame($test['expectedLastDay'], $lastDay->format('d/m/Y H:i:s'));
    }
}
