<?php
/**
 * @author Siarhei Sharykhin
 */


$strings = array(
    "PassKit",
    "Fun",
    "Hong Kong",
    "Awesome",
    "PFR",
    "Mobile",
    "Office"
);

function getLongestAndShortestItems(array $strings) {
    // Initialize variables which are responsible for the longest and the shortest items
    $convertToNumbers = array();
    $searchLongestItem = null;
    $searchShortestItem = null;

    //Fill the new array by length of each item
    array_walk($strings,function($item) use (&$convertToNumbers){
        $convertToNumbers[] = strlen($item);
    });

    $searchLongestItem = $strings[array_keys($convertToNumbers,max($convertToNumbers))[0]];
    $searchShortestItem = $strings[array_keys($convertToNumbers,min($convertToNumbers))[0]];



    return array(
        'longest' =>$searchLongestItem,
        'shortest' => $searchShortestItem
    );

}

var_dump(getLongestAndShortestItems($strings));