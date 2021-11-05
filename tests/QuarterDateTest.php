<?php

namespace App\Tests;

use App\Util\QuarterDate;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class QuarterDateTest extends KernelTestCase
{
    public function testgetDatesByQuarterAndYear(): void
    {
        $container = static::getContainer();

        /** @var QuarterDate $quarterDate */
        $quarterDate = $container->get('test.'.QuarterDate::class);

        $asserts = [
            [
                'quarter' => 1,
                'year' => 2021,
                'results' => ['startDate' => '01/01/2021 00:00:00',
                    'endDate' => '31/03/2021 23:59:59', ],
            ],
            [
                'quarter' => 2,
                'year' => 2021,
                'results' => ['startDate' => '01/04/2021 00:00:00',
                    'endDate' => '30/06/2021 23:59:59', ],
            ],
            [
                'quarter' => 3,
                'year' => 2021,
                'results' => ['startDate' => '01/07/2021 00:00:00',
                    'endDate' => '30/09/2021 23:59:59', ],
            ],
            [
                'quarter' => 4,
                'year' => 2021,
                'results' => ['startDate' => '01/10/2021 00:00:00',
                    'endDate' => '31/12/2021 23:59:59', ],
            ],
            [
                'quarter' => 5,
                'year' => 2021,
                'results' => null,
            ],
        ];

        foreach ($asserts as $assert) {
            $res = $quarterDate->getDatesByQuarterAndYear($assert['quarter'], $assert['year']);
            if (null !== $assert['results']) {
                $this->assertSame($assert['results']['startDate'], $res['startDate']->format('d/m/Y H:i:s'));
                $this->assertSame($assert['results']['endDate'], $res['endDate']->format('d/m/Y H:i:s'));
            } else {
                $this->assertNull($res);
            }
        }
    }

    public function testQuarterDateBetween(): void
    {
        $container = static::getContainer();

        /** @var QuarterDate $quarterDate */
        $quarterDate = $container->get('test.'.QuarterDate::class);

        $tests = [
            [
                'date' => \DateTime::createFromFormat('d/m/Y H:i:s', '07/01/2021 16:31:24'),
                'expectedFirstDay' => '01/01/2021 00:00:00',
                'expectedLastDay' => '31/03/2021 23:59:59',
            ],
            [
                'date' => \DateTime::createFromFormat('d/m/Y H:i:s', '01/05/2021 16:31:24'),
                'expectedFirstDay' => '01/04/2021 00:00:00',
                'expectedLastDay' => '30/06/2021 23:59:59',
            ],
            [
                'date' => \DateTime::createFromFormat('d/m/Y H:i:s', '01/07/2021 16:31:24'),
                'expectedFirstDay' => '01/07/2021 00:00:00',
                'expectedLastDay' => '30/09/2021 23:59:59',
            ],
            [
                'date' => \DateTime::createFromFormat('d/m/Y H:i:s', '27/10/2021 16:31:24'),
                'expectedFirstDay' => '01/10/2021 00:00:00',
                'expectedLastDay' => '31/12/2021 23:59:59',
            ],
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
