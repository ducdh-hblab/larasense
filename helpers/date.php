<?php

use Illuminate\Support\Carbon;

/**
 * Return a formatted Carbon date.
 */
function humanize_date(Carbon $date, string $format = 'd F Y, H:i'): string
{
    return $date->format($format);
}

function is_new($created_at): bool
{
    return strtotime($created_at) > strtotime('-1 weeks');
}
