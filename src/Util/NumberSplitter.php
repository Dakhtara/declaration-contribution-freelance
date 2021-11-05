<?php

namespace App\Util;

class NumberSplitter
{
    /**
     * This method should only return rounded value and not floating
     * For input 89900 in 3 slices we should return [30000, 30000, 29900].
     *
     * @return array|int[]
     */
    public function splitRound(float $value, int $slices, bool $asInt = true): array
    {
        //We remove the 0 at the end of the digit value 89900 => 899
        $lastDigit = substr($value, -1);
        $powExponent = 0;

        while (0 == $lastDigit) {
            $value = $value / 10;
            ++$powExponent;
            $lastDigit = substr($value, -1, 1);
        }

        //We keep the remaining modulo value
        $modSlices = fmod($value, $slices);
        $remaining = 0;
        if (0 != $modSlices) {
            $remaining = $slices - $modSlices;
        }
        $slice = ($value + $remaining) / $slices;
        $resValues = [];

        //We add each slice but not the last one.
        for ($i = 0; $i < $slices - 1; ++$i) {
            $val = $slice * pow(10, $powExponent);
            $val = $asInt ? (int) $val : $val;
            $resValues[] = $val;
        }

        //We add the lase slice which is different of the first slices
        $val = ($slice - $remaining) * pow(10, $powExponent);
        $val = $asInt ? (int) $val : $val;
        $resValues[] = $val;

        return $resValues;
    }
}
