<?php
function binarySearch($target, $array)
{
    $low = 0;
    $high = count($array) - 1;

    while ($low <= $high) {
        $middle = floor(($low + $high) / 2);
        if ($target == $array[$middle]) {
            return $middle;
        }
        if ($array[$middle] > $target) {
            $high = $middle - 1;
        } else {
            $low = $middle + 1;
        }
    }
    return -1;
}

$array = [1, 3, 5, 6, 9];
echo binarySearch(3, $array) . "\r\n";
echo binarySearch(-1, $array) . "\r\n";

