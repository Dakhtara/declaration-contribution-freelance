<?php

namespace App\Util;

use JetBrains\PhpStorm\ArrayShape;

class QuarterDate
{
    /**
     * @return array{startDate: \DateTimeInterface, endDate: \DateTimeInterface}
     */
    public function getDatesByQuarterAndYear(int $quarter, int $year): ?array
    {
        switch ($quarter) {
            case 1:
                $startDate = 'january';
                $endDate = 'march';
                break;
            case 2:
                $startDate = 'april';
                $endDate = 'june';
                break;
            case 3:
                $startDate = 'july';
                $endDate = 'september';
                break;
            case 4:
                $startDate = 'october';
                $endDate = 'december';
                break;
        }

        if (!isset($startDate) && !isset($endDate)) {
            return null;
        }

        return ['startDate' => (new \DateTime())->modify("first day of $startDate $year 000000"),
            'endDate' => (new \DateTime())->modify("last day of $endDate $year 235959"), ];
    }

    public function getFirstDayOfQuarter(\DateTimeInterface $dateTime): ?\DateTimeInterface
    {
        $month = $dateTime->format('n');
        $firstDayOfQuarter = new \DateTime();
        if ($month <= 3) {
            $startMonth = 'january';
        } elseif ($month <= 6) {
            $startMonth = 'april';
        } elseif ($month <= 9) {
            $startMonth = 'july';
        } elseif ($month <= 12) {
            $startMonth = 'october';
        }

        if (isset($startMonth)) {
            return $firstDayOfQuarter->modify('first day of '.$startMonth.' '.$dateTime->format('Y').' 000000');
        }

        return null;
    }

    public function getLastDayOfQuarter(\DateTimeInterface $dateTime): ?\DateTimeInterface
    {
        $month = $dateTime->format('n');
        $firstDayOfQuarter = new \DateTime();
        if ($month <= 3) {
            $startMonth = 'march';
        } elseif ($month <= 6) {
            $startMonth = 'june';
        } elseif ($month <= 9) {
            $startMonth = 'september';
        } elseif ($month <= 12) {
            $startMonth = 'december';
        }

        if (isset($startMonth)) {
            return $firstDayOfQuarter->modify('last day of '.$startMonth.' '.$dateTime->format('Y').' 235959');
        }

        return null;
    }

    public function getQuarter(\DateTimeInterface $dateTime): int
    {
        $month = $dateTime->format('n');
        if ($month > 12 || $month < 1) {
            throw new \Exception(sprintf("You can't find a quarter for month %s as this month doesn't exist in the calendar", $month));
        }

        if ($month <= 3) {
            return 1;
        } elseif ($month <= 6) {
            return 2;
        } elseif ($month <= 9) {
            return 3;
        } else {
            return 4;
        }
    }

    #[ArrayShape(['year' => 'int', 'quarter', 'int'])]
    public function getPreviousQuarter(\DateTime $dateTime): array
    {
        $prevQuarter = $dateTime->modify('-3 month');
        $quarter = $this->getQuarter($prevQuarter);
        $year = (int) $prevQuarter->format('Y');

        return compact('year', 'quarter');
    }
}
