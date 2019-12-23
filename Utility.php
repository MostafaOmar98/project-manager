<?php
set_time_limit(0);


/*
 * @param a date in format 'yyyy-mm-dd', and an integer days
 * returns a new date moved forward by days amount
 */
function addDaysToDate($date, $days)
{
    $time = strtotime($date);
    $time += $days * 24 * 60 * 60;
    $ret = date('Y-m-d', $time);
    return $ret;
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

function trimArray($arr)
{
    for ($i = 0; $i < sizeof($arr); $i += 1)
        $arr[$i] = trim($arr[$i]);

    return $arr;
}


?>
