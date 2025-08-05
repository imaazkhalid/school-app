<?php

namespace App\Helpers;

class GradeHelper
{
    public static function fromMarks($marks)
    {
        return match (true) {
            $marks >= 90 => 'A+',
            $marks >= 85 => 'A',
            $marks >= 80 => 'A-',
            $marks >= 75 => 'B+',
            $marks >= 70 => 'B',
            $marks >= 65 => 'B-',
            $marks >= 60 => 'C+',
            $marks >= 55 => 'C',
            $marks >= 50 => 'C-',
            $marks >= 45 => 'D+',
            $marks >= 40 => 'D',
            $marks >= 33 => 'D-',
            default => 'F',
        };
    }
}
