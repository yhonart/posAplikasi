<?php

namespace App\Helpers;

class QuarterHelper
{
    public static function getMonthsByQuarter()
    {
        return [
            'Q1' => 'Quarter 1 (January - March)',
            'Q2' => 'Quarter 2 (April - June)',
            'Q3' => 'Quarter 3 (July - September)',
            'Q4' => 'Quarter 4 (October - December)',
        ];
    }
}

?>