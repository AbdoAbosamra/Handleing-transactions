<?php

function FormatDollarAmount(float $amount): string{
    $isNegative = $amount < 0;

    return ($isNegative ? '-' : '') ."$" . number_format(abs($amount),2);
}
function formateDate(string $date): string{
    return date("M j, Y",strtotime($date));
}