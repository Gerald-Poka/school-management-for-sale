<?php

namespace App\Helpers;

class ReferenceGenerator
{
    public static function generate(): string
    {
        $prefix = 'REF';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -4));
        return "{$prefix}{$date}{$random}";
    }
}