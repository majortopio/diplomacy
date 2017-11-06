<?php

/**
 * Diplomacy Engine
 * majortopio
 */

namespace majortopio\diplomacy\functions;

class dhelper
{
    /**
     * @param integer $number
     * @return string
     */
    public function number_shorten($number)
    {
        $numlength = strlen((string)$number);
        if ($numlength < 6)
        {
            return number_format($number,0);
        }
        if ($numlength > 6 && $numlength < 10)
        {
            if($numlength == 7) {
                return substr((string)$number, 0, 1) . '.' . substr((string)$number, 1, 1) . ' million';
            }
            elseif($numlength == 8) {
                return substr((string)$number, 0, 2) . '.' . substr((string)$number, 2, 1) . ' million';
            }
            elseif($numlength == 9)
            {
                return substr((string)$number, 0, 3) . '.' . substr((string)$number, 3, 2) . ' million';
            }
        }
        elseif ($numlength > 9 && $numlength < 13)
        {
            if($numlength == 10) {
                return substr((string)$number, 0, 1) . '.' . substr((string)$number, 1, 1) . ' billion';
            }
            elseif($numlength == 11) {
                return substr((string)$number, 0, 2) . '.' . substr((string)$number, 2, 1) . ' billion';
            }
            elseif($numlength == 12)
            {
                return substr((string)$number, 0, 3) . '.' . substr((string)$number, 3, 2) . ' billion';
            }
        }
        elseif ($numlength > 12 && $numlength < 16)
        {
            if($numlength == 13) {
                return substr((string)$number, 0, 1) . '.' . substr((string)$number, 1, 1) . ' trillion';
            }
            elseif($numlength == 14) {
                return substr((string)$number, 0, 2) . '.' . substr((string)$number, 2, 1) . ' trillion';
            }
            elseif($numlength == 15)
            {
                return substr((string)$number, 0, 3) . '.' . substr((string)$number, 3, 2) . ' trillion';
            }
        }

        return $number;
    }

}