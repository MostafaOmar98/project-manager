<?php

/*
 * @param two strings in format 'yyyy-mm-dd'
 * returns 1 if $d1 > $d2, -1 if $d1 < $d2, 0 if both are equal
 */
function compareStringDates($d1, $d2)
{
    $d1 = strtotime($d1);
    $d2 = strtotime($d2);
    if ($d1 > $d2)
        return 1;
    else if ($d1 < $d2)
        return -1;
    return 0;
}

/*
 * @param a date in format 'yyyy-mm-dd', and an integer days
 * returns a new date moved forward by days amount
 */
function addDaysToDate($date, $days)
{
    $time = strtotime($date);
    $time += $days * 24 * 60 * 60;
    $date = date('Y-m-d', $time);
    return $date;
}

function checkStrlen($str, $min, $max)
{
    if (strlen($str) >= $min && strlen($str) <= $max)
        return NULL;
    return "Field length must be between $min and $max ";
}

function checkNumericLimits($x, $min, $max)
{
    if (!is_numeric($x))
        return "Field must be numeric ";
    if ($x >= $min && $x <= $max)
        return NULL;
    return "Field must be between $min and $max ";
}

?>
