<?php

namespace App\Util;

class QuarterDate
{

    /**
     * @param int $quarter
     * @param int $year
     *
     * @return array{startDate: \DateTimeInterface, endDate: \DateTimeInterface}
     */
    public function getDatesByQuarterAndYear(int $quarter, int $year): ?array
    {
        switch ($quarter) {
            case 1:
                $startDate = "january";
                $endDate = "march";
                break;
            case 2:
                $startDate = "april";
                $endDate = "june";
                break;
            case 3:
                $startDate = "july";
                $endDate = "september";
                break;
            case 4:
                $startDate = "october";
                $endDate = "december";
                break;
        }

        if (!isset($startDate) && !isset($endDate)) {
            return null;
        }
        return ['startDate' => (new \DateTime())->modify("first day of $startDate $year 000000"),
            'endDate' => (new \DateTime())->modify("last day of $endDate $year 235959")];
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
            return $firstDayOfQuarter->modify('first day of ' . $startMonth . ' ' . $dateTime->format('Y') . ' 000000');
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
            return $firstDayOfQuarter->modify('last day of ' . $startMonth . ' ' . $dateTime->format('Y') . ' 235959');
        }

        return null;
    }
}
