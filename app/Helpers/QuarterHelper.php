<?php

namespace App\Helpers;

class QuarterHelper
{
    public static function getMonthsByQuarter()
    {
        return [
            'Q1' => ['January', 'February', 'March'],
            'Q2' => ['April', 'May', 'June'],
            'Q3' => ['July', 'August', 'September'],
            'Q4' => ['October', 'November', 'December'],
        ];
    }
}

?>