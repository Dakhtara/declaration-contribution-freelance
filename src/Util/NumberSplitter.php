<?php

namespace App\Util;

class NumberSplitter
{

    /**
     * THis method should only return rounded value and not floating
     * For input 89900 in 3 slices we should return [30000, 30000, 29900]
     *
     * @param int $value
     * @param int $slices
     *
     * @return array|int[]
     */
    public function splitRound(int $value, int $slices, ?int $modulo = null): array
    {
        //We remove the 0 at the end of the digit value 89900 => 899
        $lastDigit = substr($value, -1);
        $powExponent = 0;

        while ($lastDigit == 0) {
            $value = $value / 10;
            $powExponent++;
            $lastDigit = substr($value, -1, 1);
        }

        //We keep the remaining modulo value
        $modSlices = $value % $slices;
        $remaining = 0;
        if ($modSlices !== 0) {
            $remaining = $slices - $modSlices;
        }

        $slice = ($value + $remaining) / $slices;
        $resValues = [];

        //We add each slice but not the last one.
        for ($i = 0; $i < $slices - 1; $i++) {
            $resValues[] = $slice * pow(10, $powExponent);
        }

        //We add the lase slice which is different of the first slices
        $resValues[] = ($slice - $remaining) * pow(10, $powExponent);

        return $resValues;
    }
}
