<?php

namespace Infrastructure\Formatters;

class SlackFormatter
{
    public static function data()
    {
        $records = [];

        $records['Date & Time'] = date('Y-m-d H:i:s');
        
        return $records;
    }
}
