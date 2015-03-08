<?php
/**
 * @author Siarhei Sharykhin
 */


for ($i=1; $i <= 100; $i++) {
    // Take current value of $i
    switch ($i) {
        // if $i multiples of both 4 and 8 print PassKit Rocks
        case ($i % 4 === 0 && $i % 8 === 0):
            echo "PassKit Rocks <br/>";
        // Check also if $i multiples of 8
        case ( $i % 8 === 0):
            echo "PFR <br/>";
        // And before to use "break", check if $i multiples of 4
        case ($i % 4 === 0):
            echo "PassKit <br/>";
            break;
        default:
            echo $i . "<br />";
            break;
    }
}