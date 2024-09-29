<?php

namespace Support\Utilities;

use Carbon\Carbon;

class GenerateDocumentNumbering
{
    public static function generate(string $prefix): string
    {
        $date = Carbon::now();
        $number = $prefix;
        $number = str_replace('[DD]', $date->format('d'), $number);
        $number = str_replace('[MM]', $date->format('m'), $number);
        $number = str_replace('[YY]', $date->format('y'), $number);
        $number = str_replace('[YYYY]', $date->format('Y'), $number);

        return $number;
    }
}
