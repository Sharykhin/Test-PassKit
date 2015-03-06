<?php

$nodes = array(
    //'A' => array('F'),
    'A' => array('B','F'),
    'B' => array('A','C','E'),
    'E' => array('B','F'),
    'C' => array('A','B','D','F'),
    'D' => array('C','F'),
    'F' => array('G','A'),
    'G' => array('F')
);


function searchPath(array $step, $to, $nodes,$visitedNodes,$index) {
    $path = '';
    $paths = array();
    foreach($step as $node) {

        if($node !== $to) {
            array_push($visitedNodes,$node);

            $nextStep = $nodes[$node];

            $availableNextStep = array();
            foreach($nextStep as $nextNodes) {
                if (!in_array($nextNodes,$visitedNodes)) {
                    $availableNextStep[]=$nextNodes;
                }
            }

            $path.= searchPath($availableNextStep, $to, $nodes,$visitedNodes,++$index);
            $paths[] = $path;

        } else {
            $path = implode(" -> ",$visitedNodes);
            $path .= ' -> '.$to;
            return $path;
        }
    }
    return $paths;
}

function searchPaths($nodes,$from,$to) {
    $from = strtoupper(trim($from));
    $to = strtoupper(trim($to));
    $paths = array();
    $firstAvailableStep = $nodes[$from];
    $visitedNodes = array();
    array_push($visitedNodes,$from);
    $paths = searchPath($firstAvailableStep,$to, $nodes,$visitedNodes,0);
    var_dump($paths);
}

searchPaths($nodes,'A','G');