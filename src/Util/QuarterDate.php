<?php

namespace App\Util;

class QuarterDate
{

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
            return $firstDayOfQuarter->modify('first day of ' . $startMonth . ' ' . $dateTime->format('Y'). ' 000000');
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
            return $firstDayOfQuarter->modify('last day of ' . $startMonth . ' ' . $dateTime->format('Y'). ' 235959');
        }

        return null;
    }
}
