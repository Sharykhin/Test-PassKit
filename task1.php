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

/**
 * Function finds the shortest and the longest items in array
 *
 * @param array $strings
 * @return array
 */
function getLongestAndShortestItems(array $strings) {
    // Initialzie variables which are responsible for the longest and the shortest items
    $searchLenght = 0;
    $searchLongestItem = null;
    $searchShortestItem = null;

    //Make array_walk to find the longest item comparing each item with each other
    array_walk($strings,function($item) use (&$searchLenght,&$searchLongestItem){
        if (strlen($item) > $searchLenght) {
            $searchLenght = strlen($item);
            $searchLongestItem = $item;
        }
    });

    // Make arra_walk again to find the shortest item. It depends on the longest item
    array_walk($strings,function($item) use (&$searchLenght,&$searchShortestItem){
        if (strlen($item) < $searchLenght) {
            $searchLenght = strlen($item);
            $searchShortestItem = $item;
        }
    });

    return array(
            'longest' =>$searchLongestItem,
            'shortest' => $searchShortestItem
    );
}

var_dump(getLongestAndShortestItems($strings));
